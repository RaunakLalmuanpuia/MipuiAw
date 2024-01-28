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

table, th, td {
  border: 1px solid black;
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
            <div class="mipuiaw-text-left">
                <div>Date: {{ $now }}</div>
            </div>
            <div class="mipuiaw-text-left">
                <div>Report Range :   {{ $range  }}</div>
            </div>
            <br>

            <table>
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Department</th>
                        <th>Grievance Received</th>
                        <th>Grievance Closed</th>
                        <th>Not Yet Process</th>
                        <th>Processing</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($myDepartmentCount as $index=> $report)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $report->organization_name }}</td>
                        <td>{{ $report->grievance_received }}</td>
                        <td>{{ $report->grievance_closed }}</td>
                        <td>{{ $report->grievance_not_yet_process }}</td>
                        <td>{{ $report->grievance_processing }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            <br>
             
            <br>
             
        </div>
        <footer class="mipuiaw-text-center">
            <hr>
            <div>Developed and Designed by Mizoram State e-Governance Society (MSeGS)</div>
            <div>An Autonomous Society under the Govt. of Mizoram</div>
        </footer>
    </div></body></html>

