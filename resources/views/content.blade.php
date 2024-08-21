
@extends('website._layout')

@section('title',    $page->title_ar)

@section('page_content')
  <div class="page">
        <div class="top-page">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>
                             {{$page->title_ar}}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="text">
                            <h1>{{$page->title_ar}}</h1>
                           
                            <p>
                            {!! $page->text_ar !!}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endsection
