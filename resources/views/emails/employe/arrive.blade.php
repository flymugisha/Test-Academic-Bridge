@extends('emails.template')
@section('content-mail')
    <tr>
        <td bgcolor="#ffffff">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td valign="top" style="padding: 40px 40px 20px 40px;">
                        <h1
                            style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 25px; color: #0c0c0c; font-weight: bold;">
                            Welcome Dear {{ $attendance->employe->name }} ,</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px 40px 20px 40px;">
                        <p>
                            Arrive date: {{ $attendance->arrive_time }}<br>
                        </p>
                     Welcome Have a nice day
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
