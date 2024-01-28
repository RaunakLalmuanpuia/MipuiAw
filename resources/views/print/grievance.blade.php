 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 </head>

 <style>
    .rowx{
        padding-left: 20px;
        background-color:Tomato;
    }
    .bg-grey{
        background-color:rgb(219, 219, 219);
    }

    .padding-top{
        padding-top: 10px
    }
    .mipuiaw-theme{
        font-size: 13px;
        font-family: DejaVu Sans, sans-serif, Times-Roman, Courier;
    }
    .mipuiaw-center-div{
        margin: auto;
        width: 100%;
         
    }
    .mipuiaw-text-center{
       text-align: center;
         
    }
    .mipuiaw-text-right{
       text-align: right;
         
    }
    .page {
            position: relative;
            width: 100%;
            height: 100%;
        }
     
    .content {
        margin-bottom: 50px;
    }
    footer {
    background-color:#fff;
    color: #000;
    text-align: center;
     
    position: absolute;
    bottom: 0;
    width: 100%;
    font-size: 11px;
}
 </style>

<body>
    <div class="mipuiaw-theme page">
        <div class="content">
            <div class="mipuiaw-center-div">
                <div class="mipuiaw-text-center">
                    <img width="40px" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/ashoka.png'))) }}">
                </div>
                <div class="mipuiaw-text-center">MIPUI AW</div>
                
                <div class="mipuiaw-text-center">Government of Mizoram</div>
            </div>
            <hr>
            <div class="mipuiaw-text-right">
                <div>Registration Number :  {{ $grievance->registration_number }}</div>
                <div>Date of Grievance Submission :   {{ $grievance->date_of_receipt }}</div>
            </div>
            <br>
            <div>
                <div style="font-weight: bold;">Name of Applicant : {{ $grievance->applicant_name }}</div>
                <div>
                    Phone: {{ $grievance->applicant_mobile }}, Email: {{ $grievance->applicant_email }},
                    Address : {{ $grievance->applicant_address }}, District: {{ $grievance->applicant_district }}
                </div>
            </div>
            <br>
            <div><b>Concern Department : </b> {{ $grievance->department->organization_name }} </div>
            <br>
            <div>
                <b>Grievance Description : </b>
                <div>
                    {!! nl2br($grievance->grievance_description) !!}
                </div>
            </div>
            <br>
            @if($grievance->final_remark != null)
                <div>
                    <hr>
                    <div>
                        <b>Grievance Reply:</b>
                    </div>
                    <div>
                        {!! nl2br($grievance->final_remark) !!}
                    </div>
                    <br>
                    <div>
                        Date of remark: {{ $grievance->date_of_final_remark }}
                    </div>
                    @if($grievance->update_date_of_final_remark != null)
                        <div>
                            Updated at : {{ $grievance->update_date_of_final_remark }}
                        </div>
                    @endif
                    <br>
                    <div>
                        <div>Officer Name: {{ $grievance->officer_name }}</div>
                        <div>Officer Designation: {{ $grievance->officer_designation }}</div>
                        <div>Officer Phone: {{ $grievance->officer_mobile }}</div>
                        <div>Officer Email ID: {{ $grievance->officer_email }}</div>
                    </div>
                </div>
            @endif
            <br>
            @if($grievance->appealQuestion!=null)
                <div>
                    <hr>
                    <div>
                        <b> Appeal Question:</b>
                    </div>
                    <div>
                        {!! nl2br($grievance->appealQuestion) !!}
                         
                    </div>
                    <div>
                        Appeal Date: {{ $grievance->appealQuestionDate }}
                    </div>
                    <div>
                        @if($grievance->appealReply!=null)
                            <br>
                            <div>
                               <b> Appeal Reply:</b>
                            </div>
                            <div>
                                {!! nl2br($grievance->appealReply) !!}
                            </div>
                            <div>
                                Appeal Reply Date: {{ $grievance->appealReplyDate }}
                            </div>
                            <br>
                            <div>
                                Officer Name: {{ $grievance->officer_name_daa }}
                            </div>
                            <div>
                                Officer Designation: {{ $grievance->officer_designation_daa }}
                            </div>
                            <div>
                                Officer Phone: {{ $grievance->officer_mobile_daa }}
                            </div>
                            <div>
                                Officer Email: {{ $grievance->officer_email_daa }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <footer class="mipuiaw-text-center">
            <hr>
            <div>Developed and Designed by Mizoram State e-Governance Society (MSeGS)</div>
            <div>An Autonomous Society under the Govt. of Mizoram</div>
        </footer>
    </div></body></html>

