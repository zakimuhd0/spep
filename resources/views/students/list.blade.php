@extends('layouts.pdf')

@push('styles')
    <style>
        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
         **/
        @page {
            margin: 10px 0;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1.65cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;

            /** Extra personal styles **/
            text-align: center;
            vertical-align:top;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Extra personal styles **/
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        * {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        th {
            height: 50px;
            background-color: #F5F5F5;
        }

        table td {
            height: 50px;
            padding: 0 5px;
        }

        .no-border-left {
            border-left: 0px solid;
        }
    </style>
@endpush

@section('content')
    <header>
        <b>PENYATA ELAUN PELATIH SEMESTER {{ $batchSemester }}</b> <br>
        BAGI BULAN {{ strtoupper($monthText) }}
    </header>

    <footer>
        Disahkan Oleh : <b>KAUSAR BINTI MOHD HANAPI</b> <br>
        Penolong Pengarah (Bahagian Pengurusan Pelajar dan Latihan) <br>
        Institut Latihan Perindustrian Selandar Melaka <br>
        Tarikh : 12/12/2020
    </footer>

    <main>
        <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0" width="100%">
            <thead>
            <tr>
                <th class="text-center" width="10px">BIL</th>
                <th class="text-center" width="250px">NAMA</th>
                <th class="text-center" width="80px">NO K/P</th>
                <th class="text-center" width="80px">NO AKAUN</th>
                <th class="text-center" width="200px">KURSUS</th>
                <th class="text-center" width="50px">JUMLAH (RM)</th>
                <th class="text-center" width="50px">CATATAN</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $countRecord = 0;
                    $countRow = 1;
                    $totalAllowance = 0;
                @endphp
                @foreach($recordStudentList as $data)
                    @if($countRecord == 10)
                        <tr>
                            <td colspan="4" style="border-right: 0px solid;"></td>
                            <td class="text-center" style="border-left: 0px solid;">JUMLAH KESELURUHAN</td>
                            <td class="text-center">{{$totalAllowance}}</td>
                            <td></td>
                        </tr>
                        </tbody>
                        </table> <!-- Table closed -->
                        <div class="page-break"></div> <!-- Page break -->
                        <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center" width="10px">BIL</th>
                                <th class="text-center" width="250px">NAMA</th>
                                <th class="text-center" width="80px">NO K/P</th>
                                <th class="text-center" width="80px">NO AKAUN</th>
                                <th class="text-center" width="200px">KURSUS</th>
                                <th class="text-center" width="50px">JUMLAH (RM)</th>
                                <th class="text-center" width="50px">CATATAN</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $countRecord = 0;
                                $totalAllowance = 0;
                            @endphp
                    @endif

                    <tr>
                        <td class="text-center">{{$countRow}}</td>
                        <td>{{$data->name}}</td>
                        <td class="text-center">{{$data->ic_number}}</td>
                        <td class="text-center">{{$data->bank_account_number}}</td>
                        <td class="text-center">{{$data->course->code . '-' . $data->course->name}}</td>
                        <td class="text-center">{{$data->allowance}}</td>
                        <td class="text-center"></td>
                    </tr>
                            @php
                                $countRecord++;
                                $countRow++;
                                $totalAllowance+= $data->allowance;
                            @endphp
                @endforeach
                            <tr>
                                <td colspan="4" style="border-right: 0px solid;"></td>
                                <td class="text-center" style="border-left: 0px solid;">JUMLAH KESELURUHAN</td>
                                <td class="text-center">{{$totalAllowance}}</td>
                                <td></td>
                            </tr>
            </tbody>
        </table>
    </main>
@endsection
