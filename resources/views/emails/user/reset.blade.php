@extends('emails.template')
@section('content-mail')
    <tr>
        <td bgcolor="#ffffff">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td valign="top" style="padding: 40px 40px 20px 40px;">
                        <h1
                            style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 25px; color: #0c0c0c; font-weight: bold;">
                            Welcome Dear {{ $user->firstName }} {{ $user->lastName }},</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 40px 14px 40px; text-align: left;">
                        <h1
                            style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 15px;  color: #333333; font-weight: bold;">
                            Password Forget</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0px 40px 20px 40px;">
                        <p>
                            You can reset your password by clicking on the following link:<br>
                            <a class="btn btn-info" href="{{ route('user.reset', ['token' => $token]) }}">
                                Reset your password
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
