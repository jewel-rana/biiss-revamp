<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library;
use App\LibraryAuthor;
use App\LibraryStock;
use App\LibraryTag;
use DB;

class MigrationController extends Controller
{
    public function migrateBooks()
    {
    	$books = DB::table('books')->get();

    	if( $books ){
            $count = 0;
    		foreach( $books as $book ) {
                $count++;

    			//insert into library
    			$library = new Library;
    			$library->acc_number = $book->acc_number;
    			$library->call_number = $book->call_number;
    			$library->isbn = $book->isbn;
    			$library->type = 'book';
    			$library->title = $book->title;
    			$library->author_status = $book->author_status;
    			$library->authormark = $book->authormark;
    			$library->place = $book->place;
    			$library->publisher = $book->publisher;
    			$library->publication_year = $book->publication_year;
    			$library->copy_number = ( int ) $book->copy_number;
    			$library->price = ( int ) $book->price;
    			$library->currency = $book->currency;
    			$library->from_where = $book->from_where;
    			$library->shelf = $book->shelf;
    			$library->rack = $book->rack;
    			$library->bibliography = $book->bibliography;
    			$library->book_index = $book->page_index;
    			$library->accession = ( $book->accession != null ) ? date('Y-m-d', strtotime( $book->accession ) ) : null;
    			$library->remarks = $book->remarks;
    			$library->source = $book->source;
    			$library->abstract = $book->abstract;
    			$library->volume_number = $book->volume_number;
    			$library->series = $book->series;
    			$library->pagination = $book->pagination;
    			$library->edition = $book->edition;
                $library->qr_string_unique = $this->_is_unique_qr_string( $count );
                $library->copy_number = ( $library->copy_number ) ? $library->copy_number : 1;
                $library->migration_ref = $book->id;
                $library->edate = ( $book->edate ) ? date( 'Y-m-d H:i:s', strtotime( $book->edate ) ) : date( 'Y-m-d H:i:s', time() );

                if( $book->title != null ) {
                    $library->save();

                    if( $library->id ) {
                        echo $count . ' : ' . $book->title . ' [ok]<br>';

            			//insert authors 1
            			if( ( $book->AUF != null ) || ( $book->AUM != null ) || ( $book->AUS != null ) ) {
        	    			$author = new LibraryAuthor;
        	    			$author->item_id = $library->id;
        	    			$author->author_name = $book->AUF . ' ' . $book->AUM . ' ' . $book->AUS;
        	    			// $author->auth_subject = $book->SUB;
        	    			// $author->pagi = $book->pagination;
        	    			$author->save();
        	    		}

            			//insert authors 2
            			if( $book->AUF1 != null ) {
        	    			$author1 = new LibraryAuthor;
        	    			$author1->item_id = $library->id;
        	    			$author1->author_name = $book->AUF1 . ' ' . $book->AUM1 . ' ' . $book->AUS1;
        	    			// $author->auth_subject = $book->SUB1;
        	    			// $author->pagi = $book->pagination;
        	    			$author1->save();
        	    		}

            			//insert authors 3
            			if( $book->AUTHORF2 != null ) {
        	    			$author2 = new LibraryAuthor;
        	    			$author2->item_id = $library->id;
        	    			$author2->author_name = $book->AUTHORF2 . ' ' . $book->AUTHORM2 . ' ' . $book->AUTHORS2;
        	    			// $author->auth_subject = $book->SUB2;
        	    			// $author->pagi = $book->pagination;
        	    			$author2->save();
        	    		}

            			//insert authors 4
            			if( $book->AUTHORF3 != null ) {
        	    			$author3 = new LibraryAuthor;
        	    			$author3->item_id = $library->id;
        	    			$author3->author_name = $book->AUF . ' ' . $book->AUM . ' ' . $book->AUS;
        	    			// $author->auth_subject = $book->SUB3;
        	    			// $author->pagi = $book->pagination;
        	    			$author3->save();
        	    		}

        	    		//insert subjects / tags
        	    		if( $book->SUB != null ) {
        	    			$tag = new LibraryTag;
        	    			$tag->categories = $book->SUB;
        	    			$tag->item_id = $library->id;
        	    			$tag->save();
        	    		}

        	    		//insert subjects / tags
        	    		if( $book->SUB1 != null ) {
        	    			$tag1 = new LibraryTag;
        	    			$tag1->categories = $book->SUB1;
        	    			$tag1->item_id = $library->id;
        	    			$tag1->save();
        	    		}

        	    		//insert subjects / tags
        	    		if( $book->SUB2 != null ) {
        	    			$tag2 = new LibraryTag;
        	    			$tag2->categories = $book->SUB2;
        	    			$tag2->item_id = $library->id;
        	    			$tag2->save();
        	    		}

        	    		//insert subjects / tags
        	    		if( $book->SUB3 != null ) {
        	    			$tag3 = new LibraryTag;
        	    			$tag3->categories = $book->SUB3;
        	    			$tag3->item_id = $library->id;
        	    			$tag3->save();
        	    		}

                        //insert Stock
                        $qty = ( int ) $book->copy_number;
                        $qty = ( $qty ) ? $qty : 1;

                        for( $i = 1; $i <= $qty; $i++ ) {
                            $stock = new LibraryStock;
                            $stock->item_id = $library->id;
                            $stock->copy_number = 'C-' . $i . '-' . $library->qr_string_unique;;
                            $stock->qr_string = $library->qr_string_unique;
                            $stock->issued = 0;
                            $stock->save();
                        }
                    } else {
                        echo $count . ' : ' . $book->title . ' [no]<br>';
                    }
                } else {
                    echo $count . ' : ' . $book->title . ' [no]<br>';
                }
    		}
    	}
    }

    public function migrateJournals()
    {
    	$journals = DB::table('journals')->where('type', 'Journal')->get();

    	if( $journals ){
    		$count = 0;
    		foreach( $journals as $journal ) {
    			$count++;
                echo $count . ' : ' . $journal->title . ' [ok]<br>';

    			//insert into library
    			$library = new Library;
    			$library->isbn = $journal->isbn;
    			$library->type = 'journal';
    			$library->title = $journal->title;
    			$library->article = $journal->article;
    			$library->place = $journal->place;
    			$library->publisher = $journal->publisher;
    			$library->publication_year = $journal->publication_year;
    			$library->copy_number = 1;
    			$library->from_where = $journal->from_where;
    			$library->shelf = $journal->shelf;
    			$library->rack = $journal->rack;
    			$library->friq = $journal->friq;
    			$library->accession = ( $journal->accession != null ) ? date('Y-m-d', strtotime( $journal->accession ) ) : null;
    			$library->remarks = $journal->remarks;
    			$library->source = $journal->SOUNCE;
    			$library->keywords = $journal->KEY;
                $library->volume_number = $journal->volume_number;
                $library->item_number = $journal->item_number; //was missing
    			$library->season = $journal->season; //was missing
                $library->month_of_publish = $journal->month_of_publish; //was missing
    			$library->pagination = $journal->pagination;
                $library->qr_string_unique = $this->_is_unique_qr_string( $count );
                $library->migration_ref = $journal->id;
                $library->edate = ( $journal->edate ) ? date( 'Y-m-d', strtotime( $journal->edate ) ) : date( 'Y-m-d', time() );

                if( $journal->title != null ) {
                    $library->save();

                    if( $library->id ) {
                        echo $count . ' : ' . $journal->title . ' [ok]<br>';

            			//insert authors 1
            			if( ( $journal->AUF != null ) || ( $journal->AUM != null ) || ( $journal->AUS != null ) ) {
        	    			$author = new LibraryAuthor;
        	    			$author->item_id = $library->id;
        	    			$author->author_name = $journal->AUF . ' ' . $journal->AUM . ' ' . $journal->AUS;
                            $author->author_article = $journal->article;
        	    			$author->auth_subject = $journal->KEY;
        	    			$author->pagi = $journal->pagination;
        	    			$author->save();
        	    		}

            			//insert authors 2
            			if( $journal->AUF1 != null ) {
        	    			$author1 = new LibraryAuthor;
        	    			$author1->item_id = $library->id;
        	    			$author1->author_name = $journal->AUF1 . ' ' . $journal->AUM1 . ' ' . $journal->AUS1;
        	    			$author->author_article = $journal->article;
        	    			$author->pagi = $journal->pagination;
        	    			$author1->save();
        	    		}

            			//insert authors 3
            			if( $journal->AUF3 != null ) {
        	    			$author3 = new LibraryAuthor;
        	    			$author3->item_id = $library->id;
        	    			$author3->author_name = $journal->AUF . ' ' . $journal->AUM . ' ' . $journal->AUS;
        	    			$author->author_article = $journal->article;
        	    			$author->pagi = $journal->pagination;
        	    			$author3->save();
        	    		}


                        //insert Stock Item
                        $stock = new LibraryStock;
                        $stock->item_id = $library->id;
                        $stock->copy_number = 'C-1-' . $library->qr_string_unique;
                        $stock->qr_string = $library->qr_string_unique;
                        $stock->issued = 0;
                        $stock->save();
                    
                    } else {
                        echo $count . ' : ' . $journal->title . ' [no]<br>';
                    }
                } else {
                    echo $count . ' : ' . $journal->title . ' [no]<br>';
                }
    		}
    	}
    }

    public function migrateDocuments()
    {
    	$documents = DB::table('journals')->where('type', 'Document')->get();

    	if( $documents ){
    		$count = 0;
    		foreach( $documents as $document ) {
    			$count++;

                echo $count . ' : ' . $document->title . ' [ok]<br>';

    			//insert into library
    			$library = new Library;
    			$library->isbn = $document->isbn;
    			$library->type = 'document';
    			$library->title = $document->title;
    			$library->article = $document->article;
    			$library->place = $document->place;
    			$library->publisher = $document->publisher;
    			$library->publication_year = $document->publication_year;
    			$library->copy_number = 1;
    			$library->from_where = $document->from_where;
    			$library->shelf = $document->shelf;
    			$library->rack = $document->rack;
    			$library->friq = $document->friq;
    			$library->accession = ( $document->accession != null ) ? date('Y-m-d', strtotime( $document->accession ) ) : null;
    			$library->remarks = $document->remarks;
    			$library->source = $document->SOUNCE;
    			$library->keywords = $document->KEY;
    			$library->volume_number = $document->volume_number;
                $library->item_number = $journal->item_number; //was missing
                $library->season = $journal->season; //was missing
                $library->month_of_publish = $journal->month_of_publish; //was missing
    			$library->pagination = $document->pagination;
                $library->qr_string_unique = $this->_is_unique_qr_string( $count );
                $library->migration_ref = $document->id;
                $library->edate = ( $document->edate ) ? date( 'Y-m-d', strtotime( $document->edate ) ) : date( 'Y-m-d', time() );

    			if( $document->title != null ) {
                    $library->save();

                    if( $library->id ) {
                        echo $count . ' : ' . $document->title . ' [ok]<br>';

            			//insert authors 1
            			if( ( $document->AUF != null ) || ( $document->AUM != null ) || ( $document->AUS != null ) ) {
        	    			$author = new LibraryAuthor;
        	    			$author->item_id = $library->id;
        	    			$author->author_name = $document->AUF . ' ' . $document->AUM . ' ' . $document->AUS;
                            $author->author_article = $document->article;
        	    			$author->auth_subject = $document->KEY;
        	    			$author->pagi = $document->pagination;
        	    			$author->save();
        	    		}

            			//insert authors 2
            			if( $document->AUF1 != null ) {
        	    			$author1 = new LibraryAuthor;
        	    			$author1->item_id = $library->id;
        	    			$author1->author_name = $document->AUF1 . ' ' . $document->AUM1 . ' ' . $document->AUS1;
        	    			$author->author_article = $document->article;
        	    			$author->pagi = $document->pagination;
        	    			$author1->save();
        	    		}

            			//insert authors 3
            			if( $document->AUF3 != null ) {
        	    			$author3 = new LibraryAuthor;
        	    			$author3->item_id = $library->id;
        	    			$author3->author_name = $document->AUF . ' ' . $document->AUM . ' ' . $document->AUS;
        	    			$author->author_article = $document->article;
        	    			$author->pagi = $document->pagination;
        	    			$author3->save();
        	    		}

                        //insert Stock Item
                        $stock = new LibraryStock;
                        $stock->item_id = $library->id;
                        $stock->copy_number = 'C-1-' . $library->qr_string_unique;
                        $stock->qr_string = $library->qr_string_unique;
                        $stock->issued = 0;
                        $stock->save();
                    
                    } else {
                        echo $count . ' : ' . $document->title . ' [no]<br>';
                    }
                } else {
                    echo $count . ' : ' . $document->title . ' [no]<br>';
                }
    		}
    	}
    }

    public function migrateMagazines()
    {
    	$magazines = DB::table('journals')->where('type', 'Magazine')->get();

    	if( $magazines ){
    		$count = 0;
    		foreach( $magazines as $magazine ) {
    			$count++;
    			
                echo $count . ' : ' . $magazine->title . ' [ok]<br>';

    			//insert into library
    			$library = new Library;
    			$library->isbn = $magazine->isbn;
    			$library->type = 'magazine';
    			$library->title = $magazine->title;
    			$library->article = $magazine->article;
    			$library->place = $magazine->place;
    			$library->publisher = $magazine->publisher;
    			$library->publication_year = $magazine->publication_year;
    			$library->copy_number = 1;
    			$library->from_where = $magazine->from_where;
    			$library->shelf = $magazine->shelf;
    			$library->rack = $magazine->rack;
    			$library->friq = $magazine->friq;
    			$library->accession = ( $magazine->accession != null ) ? date('Y-m-d', strtotime( $magazine->accession ) ) : null;
    			$library->remarks = $magazine->remarks;
    			$library->source = $magazine->SOUNCE;
    			$library->keywords = $magazine->KEY;
    			$library->volume_number = $magazine->volume_number;
                $library->item_number = $journal->item_number; //was missing
                $library->season = $journal->season; //was missing
                $library->month_of_publish = $journal->month_of_publish; //was missing
    			$library->pagination = $magazine->pagination;
                $library->qr_string_unique = $this->_is_unique_qr_string( $count );
                $library->migration_ref = $magazine->id;
                $library->edate = ( $magazine->edate ) ? date( 'Y-m-d', strtotime( $magazine->edate ) ) : date( 'Y-m-d', time() );

    			if( $magazine->title != null ) {
                    $library->save();

                    if( $library->id ) {
                        echo $count . ' : ' . $magazine->title . ' [ok]<br>';

            			//insert authors 1
            			if( ( $magazine->AUF != null ) || ( $magazine->AUM != null ) || ( $magazine->AUS != null ) ) {
        	    			$author = new LibraryAuthor;
        	    			$author->item_id = $library->id;
        	    			$author->author_name = $magazine->AUF . ' ' . $magazine->AUM . ' ' . $magazine->AUS;
        	    			$author->author_article = $magazine->article;
                            $author->auth_subject = $magazine->KEY;
        	    			$author->pagi = $magazine->pagination;
        	    			$author->save();
        	    		}

            			//insert authors 2
            			if( $magazine->AUF1 != null ) {
        	    			$author1 = new LibraryAuthor;
        	    			$author1->item_id = $library->id;
        	    			$author1->author_name = $magazine->AUF1 . ' ' . $magazine->AUM1 . ' ' . $magazine->AUS1;
        	    			$author->author_article = $magazine->article;
        	    			$author->pagi = $magazine->pagination;
        	    			$author1->save();
        	    		}

            			//insert authors 3
            			if( $magazine->AUF3 != null ) {
        	    			$author3 = new LibraryAuthor;
        	    			$author3->item_id = $library->id;
        	    			$author3->author_name = $magazine->AUF . ' ' . $magazine->AUM . ' ' . $magazine->AUS;
        	    			$author->author_article = $magazine->article;
        	    			$author->pagi = $magazine->pagination;
        	    			$author3->save();
        	    		}

                        //insert Stock Item
                        $stock = new LibraryStock;
                        $stock->item_id = $library->id;
                        $stock->copy_number = 'C-1-' . $library->qr_string_unique;
                        $stock->qr_string = $library->qr_string_unique;
                        $stock->issued = 0;
                        $stock->save();
                    
                    } else {
                        echo $count . ' : ' . $magazine->title . ' [no]<br>';
                    }
                } else {
                    echo $count . ' : ' . $magazine->title . ' [no]<br>';
                }
    		}
    	}
    }

    public function addMissingColumsToBooks(){
        
    }

    public function addMissingColumsToOthers( Request $request ){
        
        $query = \App\Library::with('issue');

        if( $request->get('type') != null ) {
            $query->where('type', $request->get('type') );
        }

        $items = $query->get();

        if( $items ) {
            foreach( $items as $item ) {
                //add missing item_number, month_of_publish, season columns
                $data = DB::table('journals')->find( $item->migration_ref );

                $item->season = $data->season;
                $item->month_of_publish = $data->month_of_publish;
                $item->item_number = $data->item_number;
                $item->acc_number = $data->acc_number;
                $item->save();
            }
        }
    }

    protected function _is_unique_qr_string( $count )
    {
        $query = Library::orderBy('qr_string_unique', 'desc')->first();

        return ( $query ) ? $query->qr_string_unique + $count : time() + $count;
    }
}
