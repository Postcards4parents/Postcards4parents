@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="topBanner accountInfo">
  <div class="container">
    <div class="row">
        <aside class="col-lg-3 col-md-4 d-none d-md-block">
            <ul class="leftLinks">
                <li><a href="{{ url('welcomeKit') }}"><i class="far fa-user"></i> Welcome Kit</a></li>
                <li><a href="{{ url('postcards-office-hours') }}"><i class="far fa-clock"></i> Your Postcards & Office Hours</a></li>
                <!-- <li><a href="{{ url('story-circle') }}"><i class="far fa-file-alt"></i> Story Circle</a></li> -->
                <li><a href="{{ url('userDashboard') }}"><i class="fas fa-info"></i> Account Info</a></li>	
                <li><a href="{{ url('user_log/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <aside class="col-lg-9 col-md-8 col-12">
            <h2>Kate’s Room</h2>
            <div class="qot">“ A great quote about parenting here.”<span>– QUOTE AUTHOR</span></div>
            <div class="hourTime">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Threads</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>When does your child’s impatience really get under your skin?</td>
                            <td>Dec 05 2020</td>
                        </tr>
                        <tr>
                            <td>What messages did you get about body image growing up?</td>
                            <td>Dec 05 2020</td>
                        </tr>
                        <tr>
                            <td>How do chores work in your household?</td>
                            <td>Dec 05 2020</td>
                        </tr>
                        <tr>
                            <td>Do you prefer questions or answers?</td>
                            <td>Dec 05 2020</td>
                        </tr>
                        <tr>
                            <td>What are the things your child does that scare you most?</td>
                            <td>Dec 05 2020</td>
                        </tr>
                        <tr>
                            <td>What situations tend to trigger ruptures with your child?</td>
                            <td>Dec 05 2020</td>
                        </tr>	
                    </tbody>
                </table>
                <p class="text-center loadMore"><a href="">Load more...</a></p>
            </div>
        </aside>
    </div>
  </div>
</section>


@endsection
@section('script')
    @php
        $disabledrag=1;
    @endphp
@endsection