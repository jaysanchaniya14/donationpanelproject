<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Invoice PDF</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

</head>

<body>
<div class="container">
    <table style="width: 100%">
        <tbody>
        <tr>
            <td>
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td>
                            <b>Project name:</b>{{ $donation->project->title }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Amount:</b>${{ $donation->amount }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Payment method:</b>{{ $donation->payment_method }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Transaction ID:</b>{{ $donation->transaction_id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Donation Datetime:</b>{{ date(getDateTimeFormat(), strtotime($donation->transaction_id)) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>
