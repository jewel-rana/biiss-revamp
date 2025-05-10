@extends('master.app')
<?php
use App\Category;
use App\BookReturn;
use App\Book;
use App\BookIssue;

$bookIssueInfo = BookIssue::where('id',$item->book_issue_id)->first();
if(count($bookIssueInfo)>0){
    $bookInfo = Book::where('id',$bookIssueInfo->book_id)->first();
}


?>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('book_return.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="media">
                <div class="media-left">
                    @if( $bookInfo->cover_photo !== null )
                    <a href="#">
                        <img class="media-object img-thumbnail" src="{{Request::root()}}/uploads/books/{{ $bookInfo->cover_photo }}" width="350">
                    </a>
                    @else
                        <img class="media-object img-thumbnail" src="{{ asset('default/blank-cover.png') }}" width="350">
                    @endif
                </div>
                <div class="media-body">
                    <dl class="dl-horizontal">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Title : </th>
                                    <td>{{ $bookInfo->title }}</td>
                                </tr>
                                <tr>
                                    <th>Member Name : </th>
                                    <td>{{ $bookIssueInfo->user_name }}</td>
                                </tr>
                                <tr>
                                    <th>Copy Number : </th>
                                    <td>{{ $bookIssueInfo->copy_number }}</td>
                                </tr>
                                <tr>
                                    <th>Issue Date : </th>
                                    <td>{{ $bookIssueInfo->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>Return Expire Date : </th>
                                    <td>{{ $bookIssueInfo->end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Return Date : </th>
                                    <td>{{ $item->return_date }}</td>
                                </tr>
                                <tr>
                                    <th>Late Count : </th>
                                    <td>{{ $item->late_count }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection