<?php
$emp = Session::get('employee');
// dd($emp);

$title = $menu->labeleng;
if ($emp->lang == 'fr') {
    $title = $menu->labelfr;
    App::setLocale('fr');
}

use App\Models\Branch;
use App\Models\Institution;
use App\Models\Network;
use App\Models\Zone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

$emp = Session::get('employee');
//$title = env('APP_NAME');
$logo = asset('storage/logos/logo.png');
$printed_by = trans('label.printed_by');
$date = trans('label.date');
$operation = trans('label.oper');

if ($emp->level === 'B') {
    $branch = Branch::getBranch($emp->branch);
    $institution = Institution::getInstitution($emp->institution);
    $zone = Zone::getZone($emp->zone);
    $network = Network::getNetwork($emp->network);
    $title = $branch->name;
    $logo = asset('storage/logos/' . $institution->logo);
}

if ($emp->level === 'I') {
    $branch = Branch::getBranch(Session::get('branch'));
    $institution = Institution::getInstitution($emp->institution);
    $zone = Zone::getZone($emp->zone);
    $network = Network::getNetwork($emp->network);
    $title = $institution->abbr;
    $logo = asset('storage/logos/' . $institution->logo);
}

if ($emp->level === 'Z') {
    $branch = Branch::getBranch(Session::get('branch'));
    $institution = Institution::getInstitution(Session::get('institution'));
    $zone = Zone::getZone($emp->zone);
    $network = Network::getNetwork($emp->network);
    $title = $zone->name;
    if ($institution !== null) {
        $logo = asset('storage/logos/' . $institution->logo);
    }
}

if ($emp->level === 'N') {
    $branch = Branch::getBranch(Session::get('branch'));
    $institution = Institution::getInstitution(Session::get('institution'));
    $zone = Zone::getZone(Session::get('zone'));
    $network = Network::getNetwork($emp->network);
    $title = $network->abbr;
    if ($institution !== null) {
        $logo = asset('storage/logos/' . $institution->logo);
    }
}

//dd($logo);

$operation = Session::get('operation');
?>

<!DOCTYPE html>
<html lang="{{ $emp->lang }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ $title }}</title>

    <!-- Bootstrap 3.3.7 -->

    <!-- Material Design -->
    <link href="./css/bootstrap-material-design/bootstrap-material-design.min.css" rel="stylesheet">
    <link href="./css/ripples/ripples.min.css" rel="stylesheet">
    <link href="./css/MaterialAdminLTE/MaterialAdminLTE.min.css" rel="stylesheet">

    <!-- Custom-->
    <link href="./css/myStyle.css" rel="stylesheet">

    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body style="background: white">

    <div class="row text-bold">
        <div class="col-md-5 text-center">
            <div class="row">
                <div class="col-md-12 text-bold">{{ $network->abbr }}
                    <div class="help-block text-muted">
                        {{ $network->email }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-bold">{{ $zone->name }}
                    <div class="help-block text-muted">
                        {{ $zone->email }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <img src="{{ $logo }}" class="img-circle" alt="{{ $title }}">
        </div>
        <div class="col-md-5 text-center">
            <div class="row">
                <div class="col-md-12">{{ $institution->abbr }}
                    <div class="help-block text-muted">
                        {{ $institution->email }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">{{ $branch->name }}
                    <div class="help-block text-muted">
                        {{ $branch->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row text-bold">
        <div class="col-md-4 text-center">{{ $printed_by }} : {{ $emp->name }} {{ $emp->surname }}</div>
        <div class="col-md-4 text-center">{{ $date }} : {{ \Carbon\Carbon::now()->format("d/m/Y") }}</div>
        <div class="col-md-4 text-center">{{ $operation }} : {{ $operation }}</div>
    </div>

    <strong>This is a {{ $title }} test</strong>

    <footer class="main-footer">Here is the Footer</footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
          }

          a {
            color: #5D6975;
            text-decoration: underline;
          }

          body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
          }

          header {
            padding: 10px 0;
            margin-bottom: 30px;
          }

          #logo {
            text-align: center;
            margin-bottom: 10px;
          }

          #logo img {
            width: 90px;
          }

          h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
          }

          #project {
            float: left;
          }

          #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
          }

          #company {
            float: right;
            text-align: right;
          }

          #project div,
          #company div {
            white-space: nowrap;
          }

          table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
          }

          table tr:nth-child(2n-1) td {
            background: #F5F5F5;
          }

          table th,
          table td {
            text-align: center;
          }

          table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
          }

          table .service,
          table .desc {
            text-align: left;
          }

          table td {
            padding: 20px;
            text-align: right;
          }

          table td.service,
          table td.desc {
            vertical-align: top;
          }

          table td.unit,
          table td.qty,
          table td.total {
            font-size: 1.2em;
          }

          table td.grand {
            border-top: 1px solid #5D6975;;
          }

          #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
          }

          footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
          }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <h1>INVOICE 3-2-1</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
      </div>
    </header>

    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Design</td>
            <td class="desc">Creating a recognizable design solution based on the companys existing visual identity</td>
            <td class="unit">$40.00</td>
            <td class="qty">26</td>
            <td class="total">$1,040.00</td>
          </tr>
          <tr>
            <td class="service">Development</td>
            <td class="desc">Developing a Content Management System-based Website</td>
            <td class="unit">$40.00</td>
            <td class="qty">80</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="service">SEO</td>
            <td class="desc">Optimize the site for search engines (SEO)</td>
            <td class="unit">$40.00</td>
            <td class="qty">20</td>
            <td class="total">$800.00</td>
          </tr>
          <tr>
            <td class="service">Training</td>
            <td class="desc">Initial training sessions for staff responsible for uploading web content</td>
            <td class="unit">$40.00</td>
            <td class="qty">4</td>
            <td class="total">$160.00</td>
          </tr>
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="4">TAX 25%</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$6,500.00</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
