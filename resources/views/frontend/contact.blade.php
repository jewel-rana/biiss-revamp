@extends('frontend.app')

@section('owncss')

    <style>
        .contact-text{
            text-align: justify;
        }
        .social{
            margin: 0;
            padding: 0;
            list-style: none;
            padding-bottom: 35px;
        }
        .social li{display: inline-block;}
        .social li a{
            color: #333;
            font-weight: normal;
            padding-right: 10px;
        }
        .social li a i{}
    </style>

@endsection


@section('content')

<div class="pageContent pt-4" 4>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="contact_content contact-text">
                <h3>At a Glance</h3>
                <p>Bangladesh Institute of International and Strategic Studies (BIISS) is a statutory institution established on 25 June, 1978 by the Government of the People’s Republic of Bangladesh. The Institute was established with aim of the undertaking and promoting research and deliberation on international affairs, security and developmental issues. The Institute is also expected to advance knowledge and understanding of contemporary international and strategic issues in national and regional perspectives.</p>

                <p>The Bangladesh Institute of International and Strategic Studies Ordinance. 1984, ordinance No. XXVII of 1984, BIISS Law 2013 defines the objectives, functions and organizational structure of the Institute. The general guidance and superintendence of the affairs of the Institute are vested in a Board of Governors, headed by the Chairman (appointed by the Government of the People’s Republic of Bangladesh) and consisting of Secretaries of the Ministries of Foreign Affairs, Defence and Finance, the Principal Staff Officer (PSOs) of the three services of Armed Forces, academics and professionals. The Director General of the Institute is the Member-Secretary of the Board.</p>

                <p>The Director General is the Chief Executive of BIISS who is appointed by the Government of the People’s Republic of Bangladesh. He directs and coordinates all research and administrative activities of the Institute. The research activities of the Institute are carried out by the Research Faculty consisting of a team of full-time researchers with varied social sciences background. An officer of the Armed Forces, usually of the rank of Colonel, is also deputed to the Institute to undertake research in the fields of defence related studies. The Institute is organized along territorial and functional distribution of Divisions and Desks. There are five divisions in the Research Faculty that are: (i) Defence Studies; (ii) Non-traditional Security Studies; (iii) International Studies; (vi) Strategic Studies; and (v) Peace and Conflict Studies, Each division is headed by a Research Director.</p>

                <p>The Administrative Wing, headed by a Deputy Director (Administration), and the Library and Documentation Centre, headed by a Deputy Director (Library and Documentation) of the Institute are the two other important wings providing support services and valuable inputs to research pursuits of the Institute.</p>
                <h3>Our Office</h3>
                <p>
                    Address: Dhaka<br>
                    Hours: 09:00 AM to 05:00 PM<br>
                    Founded: 1978<br>
                    Region served: Bangladesh<br>
                    Phone: 02-9336287
                </p>
                <!--<ul class="social">
                    <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href=""><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
                    <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                </ul>-->

            </div>
        </div>
    </div>
</div>
</div>



@endsection

@section('ownjs')

@endsection
