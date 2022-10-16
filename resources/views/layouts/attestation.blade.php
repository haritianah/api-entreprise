<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="UTF-8" />
    <!-- CSRF Token -->
    <title>attestation</title>
    <!-- Styles -->
    <style>

        :root {
            --blue: #3490dc;
            --indigo: #6574cd;
            --purple: #9561e2;
            --pink: #f66d9b;
            --red: #e3342f;
            --orange: #f6993f;
            --yellow: #ffed4a;
            --green: #38c172;
            --teal: #4dc0b5;
            --cyan: #6cb2eb;
            --white: #fff;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --primary: #3490dc;
            --secondary: #6c757d;
            --success: #38c172;
            --info: #6cb2eb;
            --warning: #ffed4a;
            --danger: #e3342f;
            --light: #f8f9fa;
            --dark: #343a40;
            --breakpoint-xs: 0;
            --breakpoint-sm: 576px;
            --breakpoint-md: 768px;
            --breakpoint-lg: 992px;
            --breakpoint-xl: 1200px;
            --font-family-sans-serif: "Nunito", sans-serif;
            --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        article,
        aside,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        nav,
        section {
            display: block;
        }

        body {
            margin: 0;
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
        }

        [tabindex="-1"]:focus {
            outline: 0 !important;
        }

        hr {
            box-sizing: content-box;
            height: 0;
            overflow: visible;
        }

        header{
            margin: 0 auto;
            width: 100%;
            text-align: center;
            background-color: #f8fafc;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e7e9eb;
        }

        header img{
            align-content: center;
            text-align: center;
            align-self: center;
        }

        header h1{
            text-align: center;
        }

        /*bootstrap card*/

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card > hr {
            margin-right: 0;
            margin-left: 0;
        }

        .card > .list-group:first-child .list-group-item:first-child {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .card > .list-group:last-child .list-group-item:last-child {
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }

        .card-subtitle {
            margin-top: -0.375rem;
            margin-bottom: 0;
        }

        .card-text:last-child {
            margin-bottom: 0;
        }

        .card-link:hover {
            text-decoration: none;
        }

        .card-link + .card-link {
            margin-left: 1.25rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-header + .list-group .list-group-item:first-child {
            border-top: 0;
        }

        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-footer:last-child {
            border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
        }

        .card-header-tabs {
            margin-right: -0.625rem;
            margin-bottom: -0.75rem;
            margin-left: -0.625rem;
            border-bottom: 0;
        }

        .card-header-pills {
            margin-right: -0.625rem;
            margin-left: -0.625rem;
        }

        .card-img-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 1.25rem;
        }

        .card-img {
            width: 100%;
            border-radius: calc(0.25rem - 1px);
        }

        .card-img-top {
            width: 100%;
            border-top-left-radius: calc(0.25rem - 1px);
            border-top-right-radius: calc(0.25rem - 1px);
        }

        .card-img-bottom {
            width: 100%;
            border-bottom-right-radius: calc(0.25rem - 1px);
            border-bottom-left-radius: calc(0.25rem - 1px);
        }

        .card-deck {
            display: flex;
            flex-direction: column;
        }

        /*bootstrap table*/
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody + tbody {
            border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-primary,
        .table-primary > th,
        .table-primary > td {
            background-color: #c6e0f5;
        }

        .table-primary th,
        .table-primary td,
        .table-primary thead th,
        .table-primary tbody + tbody {
            border-color: #95c5ed;
        }

        .table-hover .table-primary:hover {
            background-color: #b0d4f1;
        }

        .table-hover .table-primary:hover > td,
        .table-hover .table-primary:hover > th {
            background-color: #b0d4f1;
        }

        .table-secondary,
        .table-secondary > th,
        .table-secondary > td {
            background-color: #d6d8db;
        }

        .table-secondary th,
        .table-secondary td,
        .table-secondary thead th,
        .table-secondary tbody + tbody {
            border-color: #b3b7bb;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover > td,
        .table-hover .table-secondary:hover > th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success > th,
        .table-success > td {
            background-color: #c7eed8;
        }

        .table-success th,
        .table-success td,
        .table-success thead th,
        .table-success tbody + tbody {
            border-color: #98dfb6;
        }

        .table-hover .table-success:hover {
            background-color: #b3e8ca;
        }

        .table-hover .table-success:hover > td,
        .table-hover .table-success:hover > th {
            background-color: #b3e8ca;
        }

        .table-info,
        .table-info > th,
        .table-info > td {
            background-color: #d6e9f9;
        }

        .table-info th,
        .table-info td,
        .table-info thead th,
        .table-info tbody + tbody {
            border-color: #b3d7f5;
        }

        .table-hover .table-info:hover {
            background-color: #c0ddf6;
        }

        .table-hover .table-info:hover > td,
        .table-hover .table-info:hover > th {
            background-color: #c0ddf6;
        }

        .table-warning,
        .table-warning > th,
        .table-warning > td {
            background-color: #fffacc;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody + tbody {
            border-color: #fff6a1;
        }

        .table-hover .table-warning:hover {
            background-color: #fff8b3;
        }

        .table-hover .table-warning:hover > td,
        .table-hover .table-warning:hover > th {
            background-color: #fff8b3;
        }

        .table-danger,
        .table-danger > th,
        .table-danger > td {
            background-color: #f7c6c5;
        }

        .table-danger th,
        .table-danger td,
        .table-danger thead th,
        .table-danger tbody + tbody {
            border-color: #f09593;
        }

        .table-hover .table-danger:hover {
            background-color: #f4b0af;
        }

        .table-hover .table-danger:hover > td,
        .table-hover .table-danger:hover > th {
            background-color: #f4b0af;
        }

        .table-light,
        .table-light > th,
        .table-light > td {
            background-color: #fdfdfe;
        }

        .table-light th,
        .table-light td,
        .table-light thead th,
        .table-light tbody + tbody {
            border-color: #fbfcfc;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover > td,
        .table-hover .table-light:hover > th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark > th,
        .table-dark > td {
            background-color: #c6c8ca;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody + tbody {
            border-color: #95999c;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover > td,
        .table-hover .table-dark:hover > th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active > th,
        .table-active > td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover > td,
        .table-hover .table-active:hover > th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #343a40;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #454d55;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.075);
        }

        #app{
            padding-left: 0.5em;
            padding-right: 0.5em;
        }
    </style>
</head>
<body class="white-content">
    <header>
        <img src="{{public_path('images/solution-attestations-logo.png')}}" alt="Solution Attestations" height="120px" width="343px" align="middle">
        <h1>Justificatif D'immatriculation</h1>
        <p>Les informations contenues dans ce document sont issues des sources suivantes: Data.gouv.fr et entreprise.data.gouv.fr </p>
    </header>

    <main id="app">
        @yield('content')
    </main>
</body>
</html>
