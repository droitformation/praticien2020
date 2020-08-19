@extends('layouts.email')
@section('content')

    <tr>
        <td style="background-color: #f7f7f7;" class="content-padding" width="100%" valign="top" align="center">
            <center>
                <table class="w320" width="600" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr><td class="header-lg">Message depuis le site</td></tr>
                    <tr><td class="free-text"> &nbsp;</td></tr>
                    <tr>
                        <td class="mini-block-container">
                            <table style="border-collapse:separate !important;" width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td class="mini-block">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="user-msg">
                                                                <h2 style="margin-bottom: 30px;font-family: Arial, sans-serif;">{{ $data['nom'] ?? '' }}</h2>
                                                                <p style="font-size: 16px; font-family: Arial, sans-serif;"><strong>Email:</strong> {{ $data['email'] ?? '' }}</p>
                                                                <p style="font-size: 16px; font-family: Arial, sans-serif;">
                                                                    <strong>Message:</strong> {!! $data['remarque'] ?? '' !!}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </td>
    </tr>

@stop
