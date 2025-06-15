<?php

namespace Modules\Library\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\LibraryIssue;
use App\Models\LibraryReturn;
use App\Models\LibraryStock;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Entities\User;

class AjaxController extends Controller
{
    public function search(Request $request)
    {
        // return
        $queryParam = array();
        if (isset($_GET['search_type']) && $_GET['search_type'] == 'exact') {

            $query = "select * from `libraries` ";
            if ($request->filled('q')) {
                $search = trim($_GET['q']);
                $query .= "where (`title` LIKE '%$search%' ";
            }

            if ($request->filled('type')) {
                $type = $_GET['type'];
                $query .= "and `type` = '$type' ";
            }

            $query .= ") ";

            $query .= "or exists (select * from `library_authors` where `libraries`.`id` = `library_authors`.`item_id` and `auth_subject` LIKE '%$search%') or exists (select * from `library_tags` where `libraries`.`id` = `library_tags`.`item_id` and `categories` LIKE '%$search%') ";
        } else {
            $query = "select * from `libraries` ";
            if ($request->filled('q')) {
                $search = trim($_GET['q']);
                $query .= "where (`title` LIKE '%$search%' ";
            }

            if ($request->filled('type')) {
                $type = $_GET['type'];
                $query .= "and `type` = '$type' ";
            }

            if ($request->filled('author')) {
                $queryParam['author'] = $_GET['author'];
                $author = $_GET['author'];
                $query .= "and exists (select * from `library_authors` where `libraries`.`id` = `library_authors`.`item_id` and `library_authors`.`author_name` like '%$author%') ";
            }

            if ($request->filled(['q', 'type', 'author'])) {
                $query .= ") ";
            }

            // $query.="or exists (select * from `library_authors` where `libraries`.`id` = `library_authors`.`item_id` and `auth_subject` LIKE '%$search%') or exists (select * from `library_tags` where `libraries`.`id` = `library_tags`.`item_id` and `categories` LIKE '%$search%') ";
        }
        $queryParam['search'] = $request->get('q');


        $offset = ($_GET['start']) ? $_GET['start'] : 0;
        $limit = $_GET['length'];

        $query .= "limit $limit offset $offset";

        $items = DB::select($query);
        $count = count($items);
        $responseArr = array();
        if ($count > 0) {
            foreach ($items as $item) {
                $row['id'] = $item->id;
                $row['title'] = $item->title;
                $row['type'] = $item->type;
                $row['photo'] = (!empty($item->cover_photo)) ? asset($item->cover_photo) : asset('default/cover/' . $item->type . '.jpg');
                $row['copy_number'] = $item->copy_number;
                $row['publication_year'] = $item->publication_year;
                $row['author'] = '';
                $row['articles'] = '';
                $row['subjects'] = '';

                $authors = DB::table('library_authors')->select('*')->where('item_id', $item->id)->get();
                if (count($authors) > 0) {
                    foreach ($authors as $author) {
                        $author_name = trim($author->author_name);
                        $row['author'] .= '<a href="' . route('front.search', array_merge($queryParam, array('author' => $author_name))) . '"><span class="badge badge-default">' . $author_name . '</span></a>';
                        if (!empty($author->author_article)) {
                            if (!empty($row['articles'])) {
                                $row['articles'] .= ', ';
                            }
                            $row['articles'] .= $author->author_article;
                        }
                        if (!empty($author->auth_subject)) {
                            if (!empty($row['subjects'])) {
                                $row['subjects'] .= ', ';
                            }
                            $row['subjects'] .= $author->auth_subject;
                        }
                    }
                }


                if ($item->type == 'book' && !empty($item->tags)) {
                    foreach ($item->tags as $tag) {
                        $row['subjects'] .= $tag['categories'];
                    }
                }

                array_push($responseArr, $row);
            }
        }

        return response()->json([
            'draw' => (isset($_GET['draw'])) ? $_GET['draw'] : 0,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $responseArr
        ]);
    }

    public function search2()
    {
        $items = Library::with('authors', 'tags');

        $queryParam = array();
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            if (isset($_GET['search_type']) && $_GET['search_type'] == 'exact') {
                // $items->where('title', 'like', $_GET['q']);
                $search = trim($_GET['q']);
                $items->orWhere('title', 'LIKE', $search)
                    ->orWhereHas('authors', function ($q) use ($search) {
                        $q->where('auth_subject', 'LIKE', $search);
                    })
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('categories', 'LIKE', $search);
                    });
            } else {
                // $items->where('title', 'like', '%' . $_GET['q'] . '%');
                $search = trim($_GET['q']);
                $items->orWhere('title', 'LIKE',
                    '%' . $search . '%'
                )
                    ->orWhereHas('authors', function ($q) use ($search) {
                        $q->where('auth_subject', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('categories', 'LIKE', '%' . $search . '%');
                    });
            }
            $queryParam['search'] = $_GET['q'];
        }

        if (isset($_GET['author']) && !empty($_GET['author'])) {
            $queryParam['author'] = $_GET['author'];
            $items->whereHas('authors', function ($q) {
                $q->where('author_name', 'like', '%' . $_GET['author'] . '%');
            });
        }

        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $items->where('type', $_GET['type']);
        }

        if (isset($_GET['order'])) {
            $orderType = strtoupper((string)$_GET['order'][0]['dir']);

            if ($_GET['order'][0]['column'] == 1) {
                $fieldName = 'title';
            } elseif ($_GET['order'][0]['column'] == 3) {
                $fieldName = 'type';
            } elseif ($_GET['order'][0]['column'] == 4) {
                $fieldName = 'copy_number';
            }
        } else {
            $fieldName = 'title';
            $orderType = 'ASC';
        }

        $offset = ($_GET['start']) ? $_GET['start'] : 0;
        $limit = $_GET['length'];

        $count = $items->count();
        $items->orderBy($fieldName, $orderType);

        $items = $items->offset($offset)->limit($limit)->get();

        $responseArr = array();
        if ($count > 0) {
            foreach ($items as $item) {
                $row['id'] = $item->id;
                $row['title'] = $item->title;
                $row['type'] = $item->type;
                $row['photo'] = (!empty($item->cover_photo)) ? asset($item->cover_photo) : asset('default/cover/' . $item->type . '.jpg');
                $row['copy_number'] = $item->copy_number;
                $row['publication_year'] = $item->publication_year;
                $row['author'] = '';
                $row['articles'] = '';
                $row['subjects'] = '';
                if (!empty($item->authors)) {
                    foreach ($item->authors as $author) {
                        $author_name = trim($author['author_name']);
                        $row['author'] .= '<a href="' . route('front.search', array_merge($queryParam, array('author' => $author_name))) . '"><span class="badge badge-default">' . $author_name . '</span></a>';
                        if (!empty($author['author_article'])) {
                            if (!empty($row['articles'])) {
                                $row['articles'] .= ', ';
                            }
                            $row['articles'] .= $author['author_article'];
                        }
                        if (!empty($author['auth_subject'])) {
                            if (!empty($row['subjects'])) {
                                $row['subjects'] .= ', ';
                            }
                            $row['subjects'] .= $author['auth_subject'];
                        }
                    }
                }
                if ($item->type == 'book' && !empty($item->tags)) {
                    foreach ($item->tags as $tag) {
                        $row['subjects'] .= $tag['categories'];
                    }
                }
                array_push($responseArr, $row);
            }
        }

        $data = [
            'draw' => (isset($_GET['draw'])) ? $_GET['draw'] : 0,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $responseArr
        ];

        echo json_encode($data);
    }

    public function frontsuggestion($term = '')
    {
        $query = Library::with('authors')->orWhere('title', 'like', '%' . $term . '%')->orWhere('article', 'LIKE', '%' . $term . '%');
        if (isset($_GET['type']) && $_GET['type'] != '') :
            $query->where('type', $_GET['type']);
        endif;
        $query->orderBy('title', 'asc');

        $items = $query->get();

        $return_arr = array();
        foreach ($items as $q) {
            $row['level'] = ucwords($q->title) . '(' . ucwords($q->article) . ')' . ' (' . $q->author . ')' . '[' . $q->type . ']';

            if ($q->volume != null)
                $row['level'] .= ' [' . $q->type . '] [VOL-' . $q->volume . ']';

            if ($q->type == 'seminar')
                $row['level'] .= ' [Year-' . $q->publication_year . ']';
            $row['value'] = $q->title;
            array_push($return_arr, $row);
        }
        echo json_encode($return_arr);
    }

    public function getAllItems(Request $request)
    {
        //        dd($request);
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'book';
        $query = "SELECT libraries.id, `libraries`.`title`, libraries.document_author, libraries.type, libraries.place, libraries.source,
                    libraries.from_where, `libraries`.`season`, `libraries`.`volume_number`, libraries.item_number, `libraries`.`month_of_publish`,
                     `libraries`.`publication_year`, libraries.accession, `libraries`.`authormark`, `libraries`.`call_number`,
                      `libraries`.`acc_number`, `libraries`.`isbn`, libraries.issn, `libraries`.`publisher`, libraries.book_index,
                      `libraries`.`friq`, DATE_FORMAT(libraries.created_at, '%Y-%m-%d') as edate, libraries.remarks,
                      `library_authors`.`author_name` as `authors`, `library_authors`.`auth_subject` as `subjects`,
                      `library_authors`.`author_article` as `articles`, library_authors.pagi FROM `libraries`
                      LEFT JOIN `library_authors` ON `libraries`.`id` = `library_authors`.`item_id`
                      WHERE `libraries`.`type` = '$type'";

        if ($request->has('accno') && $request->accno != '0') {
            $accNo = $request->accno;
            $query .= " AND `libraries`.`acc_number` = '$accNo'";
        }

        if ($request->has('title') && $request->title != '0') {
            $title = $request->title;
            $query .= " AND `libraries`.`title` LIKE '%$title%'";
        }

        if ($request->has('author') && $request->author != '0') {
            $author = $request->author;
            $query .= " AND `library_authors`.`author_name` LIKE '%$author%'";
        }

        if ($request->has('subject') && $request->subject != '0') {
            $subject = $request->subject;
            $query .= " AND `library_authors`.`auth_subject` LIKE '%$subject%'";
        }

        if ($request->has('friq') && $request->friq != '0') {
            $friq = $request->friq;
            $query .= " AND `libraries`.`friq` = '$friq'";
        }

        if ($request->has('volume_number') && $request->volume_number != '0') {
            $volume_number = $request->volume_number;
            $query .= " AND `libraries`.`volume_number` = '$volume_number'";
        }

        if ($request->has('item_number') && $request->item_number != '0') {
            $item_number = $request->item_number;
            $query .= " AND `libraries`.`item_number` = '$item_number'";
        }

        if ($request->has('month') && $request->month != '0') {
            $season = $request->month;
            $query .= " AND `libraries`.`month_of_publish` LIKE '%$season%'";
        }

        if ($request->has('season') && $request->season != '0') {
            $season = $request->season;
            $query .= " AND `libraries`.`season` = '$season'";
        }
        if ($request->has('minYear') && $request->minYear != '0') {
            $minYear = $request->minYear;
            $query .= " AND `libraries`.`publication_year` >= '$minYear'";
        }

        if ($request->has('maxYear') && $request->maxYear != '0') {
            $maxYear = $request->maxYear;
            $query .= " AND `libraries`.`publication_year` <= '$maxYear'";
        }

        if ($request->has('min') && $request->min != '0') {
            $min = $request->min;
            $query .= " AND `libraries`.`edate` >= '$min'";
        }

        if ($request->has('max') && $request->max != '0') {
            $max = $request->max;
            $query .= " AND `libraries`.`edate` <= '$max'";
        }

        if ($request->has('issn') && $request->issn != '0') {
            $issn = $request->issn;
            $query .= " AND `libraries`.`issn` = '$issn'";
        }

        if ($request->has('isbn') && $request->isbn != '0') {
            $isbn = $request->isbn;
            $query .= " AND `libraries`.`isbn` = '$isbn'";
        }
        if ($request->has('publisher') && $request->publisher != '0') {
            $publisher = $request->publisher;
            $query .= " AND `libraries`.`publisher` LIKE '%$publisher%'";
        }

        if ($request->has('place') && $request->place != '0') {
            $place = $request->place;
            $query .= " AND `libraries`.`place` LIKE '%$place%'";
        }

        if ($request->has('remarks') && $request->remarks != '0') {
            $remarks = $request->remarks;
            $query .= " AND `libraries`.`remarks` LIKE '%$remarks%'";
        }

        if ($request->has('source') && $request->source != '0') {
            $source = $request->source;
            $query .= " AND `libraries`.`source` LIKE '%$source%'";
        }
        if ($request->has('from') && $request->from != '0') {
            $from = $request->from;
            $query .= " AND `libraries`.`from_where` LIKE '%$from%'";
        }
        if ($request->has('accession') && $request->accession != '0') {
            $accession = $request->accession;
            $query .= " AND `libraries`.`accession` LIKE '%$accession%'";
        }
        if ($request->has('document_author') && $request->document_author != '0') {
            $document_author = $request->document_author;
            $query .= " AND `libraries`.`document_author` LIKE '%$document_author%'";
        }

        $query .= ' ORDER BY `libraries`.`title` ASC';

        $items = DB::select($query);

        $posts = collect($items, []);

        header('Content-Type: application/json');
        return json_encode(array('data' => $posts));
    }


    public function getAllItem(Request $request)
    {
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'book';

        $items = Library::select('id', 'title', 'authormark', 'isbn', 'call_number', 'acc_number', 'item_number', 'type', 'publisher', 'friq')->with(['authors', 'tags'])->where('type', $type)->get();

        $map = $items->map(function ($item) {
            $data->checkboxes = '<input type="checkbox" name="id[]" value="' . $item->id . '" class="itemcheckbox">';

            $str = '<div class="btn-group">';
            if (strtolower($item->type) == 'book') {
                $str .= '<a href="' . route('issue.create', $item->id) . '" onclick="addToplisted(' . $item->id . ');" target="_blank" class="btn btn-success" target="_blank" id="' . $item->id . '"><i class="fa fa-plus"></i> Issue</a>';
            }
            $str .= '<a href="' . route('dashboard.library.view', $item->id) . '" onclick="viewItem(' . $item->id . ');" target="_blank" class="btn btn-primary" target="_blank" id="' . $item->id . '"><i class="fa fa-eye"></i> View</a>';

            $str .= '<a href="' . route('dashboard.library.edit', $item->id) . '" class="btn btn-success" target="_blank" id="' . $item->id . '"><i class="fa fa-edit"></i> Edit</a>';

            $str .= '<a href="#" onclick="deleteLibraryItem(' . $item->id . ');" class="btn btn-danger" id="' . $item->id . '"><i class="fa fa-times"></i> Delete</a>';

            $str .= '</div>';

            $data->action = $str;

            $data->authors = $this->_createCommaSeperatedAuthors($item->authors);
            $data->subjects = $this->_createCommaSeperatedSubjects($item->authors);
            $data->articles = $this->_createCommaSeperatedArticles($item->authors);
            $data->tags = $this->_createCommaSeperatedTags($item->tags);
            return $data;
        });

        return json_encode(array('data' => $map));
    }

    protected function _createCommaSeperatedAuthors($authors)
    {
        $str = '';
        if ($authors) {
            foreach ($authors as $author) {
                $str .= ($author['author_name']) ? $author['author_name'] . ', ' : '';
            }
        }

        return $str;
    }

    protected function _createCommaSeperatedSubjects($authors)
    {
        $str = '';
        if ($authors) {
            foreach ($authors as $author) {
                $str .= ($author['auth_subject']) ? $author['auth_subject'] . ', ' : '';
            }
        }

        return $str;
    }

    protected function _createCommaSeperatedArticles($articles)
    {
        $str = '';
        if ($articles) {
            foreach ($articles as $article) {
                $str .= ($article['author_article']) ? $article['author_article'] . ', ' : '';
            }
        }

        return $str;
    }

    protected function _createCommaSeperatedTags($tags)
    {
        $str = '';
        if ($tags) {
            foreach ($tags as $tag) {
                $str .= ($tag['categories']) ? $tag['categories'] . ', ' : '';
            }
        }

        return $str;
    }

    public function deleteItem($id)
    {
        $item = Library::findOrFail($id);

        if (!$item)
            return response()->json(['success' => false]);

        $ok = $item->delete();

        if ($ok) :
            return response()->json(['success' => true]);
        else :
            return response()->json(['success' => false]);
        endif;
    }

    public function categorysuggestion($term = '')
    {
        $query = Category::Where('name', 'like', '%' . $term . '%');
        if (isset($_GET['type']) && $_GET['type'] != '') :
            $query->where('type', $_GET['type']);
        endif;
        $query->orderBy('name', 'asc');
        $items = $query->get();

        $return_arr = array();
        foreach ($items as $q) {
            $row['level'] = ucwords($q->name);
            $row['value'] = $q->name;
            array_push($return_arr, $row);
        }

        echo json_encode($return_arr);
    }

    public function authorsuggestion($term = '')
    {
        $query = LibraryAuthor::select('author_name', 'id')->where('author_name', 'like', '%' . $term . '%');
        $query->orderBy('author_name', 'asc');
        $query->limit(50);
        $items = $query->get();

        $return_arr = array();
        foreach ($items as $q) {
            $row['level'] = ucwords($q->author_name);
            $row['value'] = $q->author_name;
            array_push($return_arr, $row);
        }

        echo json_encode($return_arr);
    }

    public function suggestion($term = '')
    {
        $query = Library::where('title', 'like', '%' . $term . '%')->orWhere('acc_number', 'like', '%' . $term . '%');
        if (isset($_GET['type']) && $_GET['type'] != '') :
            $query->where('type', $_GET['type']);
        endif;

        $query->orderBy('title', 'asc');
        $items = $query->get();

        // return $items;

        $return_arr = array();
        foreach ($items as $q) {
            $author = ($q->author) ? $q->author : 'n/a';
            $acc = ($q->acc_number) ? $q->acc_number : 'n/a';
            // $publisher = ($q->publisher)?$q->publisher:'n/a';
            $edition = ($q->edition) ? $q->edition : 'n/a';
            // $volume_number = ($q->volume_number)?$q->volume_number:'n/a';

            $row['level'] = ucwords($q->title) . ' (Author:' . $author . ', Acc No:' . $acc . ', Edition:' . $edition . ')';
            if ($q->volume_number != null)
                $row['level'] .= ' [VOL-' . $q->volume_number . ']';

            if ($q->type == 'seminar')
                $row['level'] .= ' [Year-' . $q->publication_year . ']';

            $row['value'] = $q->id;
            array_push($return_arr, $row);
        }
        // return $return_arr;
        echo json_encode($return_arr);
    }

    public function singleitem($id)
    {
        $item = Library::find($id);

        $photo = ($item->cover_photo == !null) ? asset('uploads/books/' . $item->cover_photo) : asset('images/smallbook.jpeg');
        echo '
                <li>
                    <a href="#" class="result-image" style="background-image: url(' . $photo . ')"></a>
                    <div class="result-info">
                    <h4 class="title">
                        <a href="javascript:;">' . $item->title . '</a>
                    </h4>
                    <p class="location">Author : ' . $item->author . '</p>
                    <p class="desc">' . $item->description . '</p>
                    </div>
                    <div class="result-price">
                        <a href="' . url('dashboard/feature/add/' . $item->id) . '" class="btn btn-info btn-block">Add to list</a>
                    </div>
                </li>
            ';
    }

    //getting single item as json format by itemID
    public function single($id)
    {
        $item = Library::find($id);
        $avail = array();
        $issued = ( array )$item->issuedCopies;

        for ($i = 1; $i <= $item->copy; $i++) :
            $copy = 'c-' . $i . '-' . $item->qr_string_unique;
            if (!in_array($copy, $issued)) :
                array_push($avail, $copy);
            endif;
        endfor;

        $item['copiesAvailable'] = $avail;

        echo json_encode($item);
    }

    public function memberSuggestion(Request $request): JsonResponse
    {
        $term = $request->term;
        $query = User::where(function($query) use($term) {
            $query->where('name', 'like', '%' . $term . '%');
            $query->orWhere('email', 'like', '%' . $term . '%');
        });
        $query->orderBy('name', 'asc');
        $items = $query->take(5)->get();

        $return_arr = array();
        foreach ($items as $q) {
            $row['level'] = $q->name . ' (' . $q->email . ')';
            $row['value'] = $q->account_id;
            $return_arr[] = $row;
        }

        return response()->json($return_arr);
    }

    public function extendIssue(Request $request)
    {
        $issue = LibraryIssue::findOrFail($request->issue_id);

        $issue->end_date = date('Y-m-d', strtotime("+ {$request->issueDays} Day", strtotime($issue->end_date)));

        $issue->save();

        $stock_id = ( int )$issue->stock_id;

        //update stock
        $stock = LibraryStock::findOrFail($stock_id);
        if ($stock) :
            $stock->issued = 1;
            $stock->save();
        endif;

        if ($issue->id):

            echo json_encode(array('status' => true, 'msg' => 'Your item has been successfully Re-Issued.'));
        else :
            echo json_encode(array('status' => false, 'msg' => 'Cannot Process your request.'));
        endif;
    }

    public function issueReturn(Request $request)
    {
        //get issue info
        $stock_id = ( int )$request->id;
        $issue = LibraryIssue::where(['stock_id' => $stock_id, 'is_returned' => 0])->first();

        if ($issue) :
            //create return issue
            $return = new LibraryReturn();
            $return->item_id = $issue->item_id;
            $return->admin_id = Auth::user()->id;
            $return->user_id = $issue->user_id;
            $return->return_date = date('Y-m-d H:i:s');
            $return->issue_id = $issue->id;

            $dif = date_diff(Carbon::parse($issue->end_date), Carbon::parse($return->return_date));
            $return->late_count = ($dif->format("%R%a") > 0) ? $dif->format("%a") : 0;

            //save now
            $return->save();

            //update stock
            DB::table('library_issues')
                ->where('id', $issue->id)  // find your user by their email
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update(array('is_returned' => 1));


            //update stock
            DB::table('library_stocks')
                ->where('id', $stock_id)  // find your user by their email
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update(array('issued' => 0));

            if ($return->id) :
                echo json_encode(array('status' => true, 'msg' => 'Your item has been successfully returned.'));
            else :
                echo json_encode(array('status' => false, 'msg' => 'Issue cannot return.'));
            endif;
        else :
            echo json_encode(array('status' => false, 'msg' => 'Sorry! this item already return or never Issued.'));
        endif;
    }

    public function addMoreCopy(Request $request)
    {
        //validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:libraries,id'
        ]);

        //validation fails
        if ($validator->fails())
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()], 403);

        //fetch item of the library
        $item = Library::find($request->id);

        // dd( $item );

        //add 1 more copy
        $copy = ( int )$item->copy_number;
        $copy = $copy + 1;
        $copy_number = 'C-' . $copy . '-' . $item->qr_string_unique;
        $stock = new LibraryStock();
        $stock->copy_number = $copy_number;
        $stock->qr_string = $item->qr_string_unique;
        $stock->item_id = $item->id;
        $stock->issued = 0;
        $stock->save();

        if ($stock->id) {
            //update total copy count in the library table
            $item->copy_number = $item->copy_number + 1;
            $ok = $item->save();

            if ($ok) {
                return response()->json(['success' => true, 'msg' => '1 new copy added.'], 200);
            } else {
                //roleback new item added to stocks
                $stock->delete();

                return response()->json(['success' => false, 'msg' => 'Sorry! something went wrong.'], 403);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'Sorry! something went wrong.'], 403);
        }
    }

    public function lostItem(Request $request): JsonResponse
    {

        //validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:library_stocks,id',
            'copy' => 'required|exists:library_stocks,copy_number'
        ]);

        //validation fails
        if ($validator->fails())
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()], 403);

        //change status to lost
        $item = LibraryStock::find($request->id);
        $item->issued = 2;
        $ok = $item->save();

        if ($ok) {
            return response()->json(['success' => true, 'msg' => 'Item status changed to Lost.'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Sorry! something went wrong. Try again.'], 403);
        }
    }

    //getting single item as json format by itemID
    public function member_single($id)
    {
        $item = User::find($id);

        echo json_encode($item);
    }

    public function create(Request $request)
    {
        //validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191'
        ]);

        //validation fails
        if ($validator->fails())
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()], 401);

        $library = new Library();
        $library->title = $request->title;
        $library->acc_number = ($request->acc_number) ? $request->acc_number : null;
        $library->call_number = ($request->call_number) ? $request->call_number : null;
        $library->type = ($request->type) ? $request->type : 'book';
        $library->price = ($request->price) ? $request->price : null;
        $library->currency = ($request->currency) ? $request->currency : null;
        $library->authormark = ($request->authormark) ? $request->authormark : null;
        $library->document_author = ($request->document_author) ? $request->document_author : null;
        $library->author_status = ($request->author_type) ? $request->author_type : 'author';
        $library->accession = ($request->accession) ? $request->accession : null;
        $library->month_of_publish = ($request->month_of_publish) ? $request->month_of_publish : null;
        $library->publication_year = ($request->publication_year) ? $request->publication_year : null;
        $library->copy_number = ($request->copy_number) ? $request->copy_number : 1;
        $library->isbn = ($request->isbn) ? $request->isbn : null;
        $library->issn = ($request->issn) ? $request->issn : null;
        $library->friq = ($request->friq) ? $request->friq : null;
        $library->season = ($request->season) ? $request->season : null;
        $library->place = ($request->place) ? $request->place : null;
        $library->from_where = ($request->from_where) ? $request->from_where : null;
        $library->source = ($request->source) ? $request->source : null;
        $library->publisher = ($request->publisher) ? $request->publisher : null;
        $library->item_number = ($request->item_number) ? $request->item_number : null;
        $library->volume_number = ($request->volume) ? $request->volume : null;
        $library->series = ($request->series) ? $request->series : null;
        $library->bill_and_voucher = ($request->bill_and_voucher) ? $request->bill_and_voucher : null;
        $library->bibliography = ($request->bibliography) ? $request->bibliography : null;
        $library->book_index = ($request->book_index) ? $request->book_index : null;
        $library->remarks = ($request->remarks) ? $request->remarks : null;
        $library->qr_string_unique = time() + mt_rand(100000, 999999);
        $library->cover_photo = ($request->cover_photo) ? $request->cover_photo : null;
        $library->file = ($request->file) ? $request->file : null;
        $library->has_e_resource = $request->filled('file');
        $library->e_resource_only = $request->filled('e_resource_only');
        $ok = $library->save();

        if ($ok) :

            //Add copies to library_stocks table
            if ($library->copy_number && !$request->filled('e_resource_only')) :
                for ($i = 1; $i <= $library->copy_number; $i++) :
                    $copynumber = 'C-' . $i . '-' . $library->qr_string_unique;
                    $stock = LibraryStock::firstOrNew(['item_id' => $library->id, 'copy_number' => $copynumber]);
                    $stock->copy_number = $copynumber;
                    $stock->qr_string = $library->qr_string_unique;
                    $stock->issued = 0;
                    $stock->save();
                endfor;
            endif;

            //save author information to authors table
            if ($request->authorName || $request->authorSubject || $request->authorArticle) :
                foreach ($request->authorName as $key => $author) :
                    DB::table('library_authors')
                        ->insert([
                            'item_id' => $library->id,
                            'author_name' => $author,
                            'auth_subject' => $request->authorSubject[$key],
                            'author_article' => $request->authorArticle[$key],
                            'pagi' => $request->authorPaginate[$key]
                        ]);
                endforeach;
            endif;

            //update new subjects
            // if( !empty( $request->subjects ) ) :
            //     foreach( $request->subjects as $subject ) :
            //         DB::table('library_tags')
            //             ->insert([
            //                 'item_id' => $library->id,
            //                 'categories' => $subject
            //             ]);
            //     endforeach;
            // endif;

            //return response as json
            return response()->json(['success' => true], 200);
        else :
            return response()->json(['success' => false, 'msg' => 'Cannot save, something happend wrong.'], 401);
        endif;
    }

    public function update(Request $request)
    {
        //validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191'
        ]);

        //validation fails
        if ($validator->fails())
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()], 401);

        $library = Library::findOrFail($request->id);
        $library->title = ($request->title) ? $request->title : $library->title;
        $library->acc_number = ($request->acc_number) ? $request->acc_number : null;
        $library->call_number = ($request->call_number) ? $request->call_number : null;
        $library->authormark = ($request->authormark) ? $request->authormark : null;
        $library->document_author = ($request->document_author) ? $request->document_author : null;
        $library->price = ($request->price) ? $request->price : null;
        $library->currency = ($request->currency) ? $request->currency : null;
        $library->author_status = ($request->author_type) ? $request->author_type : null;
        $library->accession = ($request->accession) ? $request->accession : null;
        $library->month_of_publish = ($request->month_of_publish) ? $request->month_of_publish : null;
        $library->publication_year = ($request->publication_year) ? $request->publication_year : null;
        $library->isbn = ($request->isbn) ? $request->isbn : null;
        $library->issn = ($request->issn) ? $request->issn : null;
        $library->friq = ($request->friq) ? $request->friq : null;
        $library->season = ($request->season) ? $request->season : null;
        $library->pagination = ($request->pagination) ? $request->pagination : null;
        $library->place = ($request->place) ? $request->place : null;
        $library->from_where = ($request->from_where) ? $request->from_where : null;
        $library->publisher = ($request->publisher) ? $request->publisher : null;
        $library->item_number = ($request->item_number) ? $request->item_number : null;
        $library->volume_number = ($request->volume) ? $request->volume : null;
        $library->series = ($request->series) ? $request->series : null;
        $library->bill_and_voucher = ($request->bill_and_voucher) ? $request->bill_and_voucher : null;
        $library->bibliography = ($request->bibliography) ? $request->bibliography : null;
        $library->book_index = ($request->book_index) ? $request->book_index : null;
        $library->remarks = ($request->remarks) ? $request->remarks : null;
        $library->source = ($request->source) ? $request->source : null;
        $library->cover_photo = ($request->cover_photo) ? $request->cover_photo : $library->cover_photo;
        $library->file = ($request->file) ? $request->file : $library->file;
        $library->e_resource_only = $request->filled('e_resource_only');

        $ok = $library->save();

        if ($ok) :

            //delete all authors information
            DB::table('library_authors')
                ->where('item_id', $library->id)
                ->delete();

            //save author information to authors table
            if ($request->authorName) :
                foreach ($request->authorName as $key => $author) :
                    DB::table('library_authors')
                        ->insert([
                            'item_id' => $library->id,
                            'author_name' => $author,
                            'auth_subject' => (isset($request->authorSubject[$key])) ? $request->authorSubject[$key] : null,
                            'author_article' => (isset($request->authorArticle[$key])) ? $request->authorArticle[$key] : null,
                            'pagi' => (isset($request->authorPaginate[$key])) ? $request->authorPaginate[$key] : null
                        ]);
                endforeach;
            endif;

            //remove subjects
            // DB::table('library_tags')
            //     ->where('item_id', $library->id )
            //     ->delete();

            // //update new subjects
            // if( !empty( $request->subjects ) ) :
            //     foreach( $request->subjects as $subject ) :
            //         DB::table('library_tags')
            //             ->insert([
            //                 'item_id' => $library->id,
            //                 'categories' => $subject
            //             ]);
            //     endforeach;
            // endif;

            //return response as json
            return response()->json(['success' => true], 200);
        else :
            return response()->json(['success' => false, 'msg' => 'Cannot save, something happend wrong.'], 401);
        endif;
    }

    public function deleteAuthor(Request $request)
    {
        $id = ( int )$request->id;

        $ok = DB::table('library_authors')
            ->where('id', $id)
            ->delete();

        if ($ok) :
            return response()->json(['success' => true], 200);
        else :
            return response()->json(['success' => false, 'msg' => 'Cannot delete author.'], 401);
        endif;
    }

    public function catSuggest($term = '')
    {
        $term = (isset($_GET['search'])) ? $_GET['search'] : $term;
        $query = Category::orWhere('name', 'like', '%' . $term . '%');
        $query->orderBy('name', 'asc');
        $items = $query->paginate(25);

        $return_arr = array();
        foreach ($items as $q) {
            $row['id'] = ucwords($q->name);
            $row['text'] = $q->name;
            array_push($return_arr, $row);
        }

        return json_encode(array('results' => $return_arr));
    }

    public function jqupload(Request $request)
    {
        //validation rules
        $validator = Validator::make($request->all(), [
            'uploadfile' => 'required|mimes:jpeg,bmp,png,pdf,txt,doc,docx|max:512000',
        ]);

        //validation fails
        if ($validator->fails())
            return response()->json(['success' => false, 'msg' => $validator->errors()->first()], 401);

        //upload file
        $file = $request->file('uploadfile');

        $filename = $request->file('uploadfile')->store('uploads/libraries');
        $extension = $file->getClientOriginalExtension();
        $type = (in_array($extension, array('pdf', 'txt', 'doc', 'docs', 'odt', 'xls', 'csv', 'sql'))) ? 'file' : 'image';

        return response()->json(['success' => true, 'filename' => $filename, 'filelink' => asset($filename), 'ext' => $extension, 'type' => $type]);
    }
}
