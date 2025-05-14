<?php


namespace Modules\Library\App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Library;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(): View
    {
        $type = ( isset( $_GET['type'] ) ) ? $_GET['type'] : 'book';
        $data['items'] = Feature::with(['item'])->where('type', $type)->get();
        $data['pageTitle'] = 'Featured Top ' . ucwords( str_replace( '_', ' ', $type ) ) . 's';
        $data['type'] = $type;
        return view('library::feature.index', $data );
    }

    public function create( Request $request ): View
    {
        $data['type'] = ( $request->type ) ? $request->type : 'book';
        $data['search'] = ( $request->search ) ? $request->search : '';

        //get few list from the library items by type
        $query = Library::with('featured')->where('title', '!=', '');

        //if user provide type then use this condition
        if( isset( $_GET['type'] ) && $_GET['type'] != '' )
            $type = ($data['type'] == 'new_book' ) ? 'book' : $data['type'];
            $query->where( 'type', $type );

        //if title parameter supplied then run this condition
        $search = (isset( $_GET['search'] ) ) ? trim($_GET['search']) : '';
        if( isset( $_GET['search'] ) && !empty( $_GET['search'] ) ) :
            $query->where('title', 'LIKE', "%{$search}%");
            // $query->where('author', 'LIKE', "%{$search}%");
        endif;

        $data['items'] = $query->paginate(10);
        $data['title'] = 'Add new featured ' . ucfirst( $data['type'] );
        return view('library::feature.create', $data );
    }

    public function add( $id ): RedirectResponse
    {
        $item = Library::find( $id );

        $feature = new Feature;
        $feature->book_id = $item->id;
        $feature->type = $type = ( isset( $_GET['type'] ) && $_GET['type'] != '' ) ? $_GET['type'] : $item->type;
        $feature->save();

        return redirect()->back()->with('success', 'Featured Item has been added.');
    }

    public function show($id): View
    {
        $data['title'] = '';
        return view('library::feature.show', $data );
    }

    public function destroy(Request $request, Feature $feature ): JsonResponse
    {
        try {
            $feature->delete();
            return response()->json([ 'success' => true, 'message' => __('Success')]);
        } catch ( \Exception $e ) {
            LogHelper::exception($e, [
                'keyword' => 'Feature Destroy exception'
            ]);
            return response()->json([ 'success' => false, 'message' => __('Failed')]);
        }
    }
}
