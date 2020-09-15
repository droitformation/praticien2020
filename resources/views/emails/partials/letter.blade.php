<table border="0" width="100%" bgcolor="f9f9f9" align="center" cellpadding="0" cellspacing="0">
    <tr><td height="15"></td></tr>
    <tr>
        <td width="100%" align="center" valign="top" bgcolor="#f9f9f9">

            <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container-y">
                <tr>
                    <td height="30" align="center"><a style="font-family: Arial,sans-serif; font-size: 12px;color: #000;" href="{{ secure_url('newsletter/preview/'.$date->toDateString()) }}">Voir dans le navigateur</a></td>
                </tr>
            </table>
            <!-- -------   top header   ---------- -->
           {{--
              <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container-y">
                <tr bgcolor="0f4060"><td height="14"></td></tr>
                <tr bgcolor="0f4060">
                    <td align="center">
                        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="container-y-middle">
                            <tr>
                                <td>
                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-left">
                                        <tr>
                                            <td align="center">
                                                <table border="0" width="600" cellpadding="0" cellspacing="0" class="date">
                                                    <tr>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td mc:edit="date" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">{{ $date->formatLocalized("%A %d %B %Y") }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table><!-- end icon calendar and date -->
                                    <table border="0" align="left" width="10" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
                                        <tr><td width="10" height="20"></td></tr>
                                    </table>
                                    <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="tel">
                                                    <tr>
                                                        <td></td>
                                                        <td>&nbsp;</td>
                                                        <td mc:edit="tel" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                                            <a style="color:#fff;text-decoration: none !important;" href="mailto:info@droitpourlepraticien.ch">info@droitpourlepraticien.ch</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr bgcolor="0f4060"><td height="10"></td></tr>
            </table>
--}}
            <!-- --------    end top header    ---------- -->
            <!-- --------    Start AD   ---------- -->
            @if(isset($annonce))
                <table width="600" cellpadding="0" cellspacing="0" align="center" class="container-y" style="border: 3px solid #9c8b6f; border-top: 0px; border-collapse: collapse; margin-bottom: 15px;">
                    <tr bgcolor="#9c8b6f">
                        <td align="center" valign="middle" height="35" style="color: #fff;"><p>Annonce</p></td>
                    </tr>
                    <tr bgcolor="#ffffff"><td height="10"></td></tr>
                    <tr bgcolor="#ffffff">
                        <td align="center">
                            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-y-middle">
                                <tr bgcolor="#ffffff"><td height="10"></td></tr>
                                <tr>
                                    <td align="top" valign="top" width="120px">
                                        <a target="_blank" href="{{ $annonce->link }}"><img class="img-thumbnail" width="120px" src="{{ $annonce->image }}"></a>
                                    </td>
                                    <td align="top" valign="top" width="40"></td>
                                    <td align="top" valign="top" >
                                        <h4 style="font-family:Arial, sans-serif;color: #000; font-weight: 600;font-size: 1.30rem; line-height: 1.2; margin: 5px 0 5px 0;">{{ $annonce->title }}</h4>
                                        <div>{!! $annonce->content !!}</div>
                                        <p><a target="_blank" href="{{ $annonce->link }}" class="btn-newsletter">Inscription</a></p>
                                    </td>
                                </tr>
                                <tr bgcolor="#ffffff"><td height="10"></td></tr>
                            </table>
                        </td>
                    </tr>
                    <tr bgcolor="#ffffff"><td height="10"></td></tr>
                </table>
            @endif
            <!-- --------  End AD   ---------- -->
            <!-- --------  main content--------- -->
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container-y" bgcolor="ffffff">

                <!-- ------- main section ------- -->
                <tr align="center">
                    <td bgcolor="ffffff">
                        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="container-y-middle">
                            <tr bgcolor="ffffff"><td height="14"></td></tr>
                            <tr bgcolor="ffffff">
                                <td width="20"></td>
                                <td>
                                    <a style="font-family: Arial,sans-serif; text-transform: uppercase; font-size: 25px; text-decoration: none;" href="{{ url('/') }}">
                                        <span style="color:#9c8b6f;">Droit</span>
                                        <span style="color:#0f4060;">pour le praticien</span>
                                    </a>
                                </td>
                                <td align="right"><img width="95" height="65" src="{{ secure_asset('images/unine.png') }}" alt="UniNE" /></td>
                                <td width="20"></td>
                            </tr>
                            <tr bgcolor="ffffff"><td height="14"></td></tr>
                        </table>

                        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="container-y-middle">
                            <tr bgcolor="ffffff">
                                <td align="center">
                                    <a href="{{ url('/') }}">
                                        <img style="display: block;" class="main-image" width="600" height="131" src="{{ secure_asset('images/main-img.png') }}" alt="dernières publications du TF" />
                                    </a>
                                </td>
                            </tr>
                            <tr bgcolor="ffffff"><td height="20"></td></tr>
                            <tr bgcolor="ffffff">
                                <td>
                                    <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                                        <tr>
                                            <td mc:edit="title1" class="main-header" style=" text-align:center; color: #0f4060; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                                Semaine du <strong>{{ $week }}</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr bgcolor="ffffff"><td align="center" height="14" width="600"></td></tr>
                            <tr bgcolor="#e4e4e4"><td align="center" height="1" width="600"></td></tr>
                        </table>

                    </td>
                </tr><!-- ------- end main section ------- -->

                <tr mc:repeatable="campaigner" mc:variant="vertical space"><td height="15"></td></tr>

                @if(!$decisions->isEmpty())
                    @foreach($decisions as $decision)
                        @include('emails.partials.decision', ['decision' => $decision])
                    @endforeach
                @endif

            </table>

            <!-- ---------- end main Content --------------- -->

            <!-- -------- footer  ------- -->
            <table border="0" width="600" cellpadding="0" cellspacing="0" class="container-y" align="center">
                <tr bgcolor="0f4060"><td height="20"></td></tr>
                <tr bgcolor="0f4060">
                    <td align="center" mc:edit="copy1" style="color: #d9e6ef; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" class="prefooter-header">
                        Vous recevez cette newsletter depuis le site <a style="color: #fff;" href="{{ secure_url('/') }}">www.droitpraticien.ch</a>
                    </td>
                </tr>
                <tr bgcolor="0f4060"><td height="5"></td></tr>
                <tr bgcolor="0f4060">
                    <td align="center" mc:edit="copy1" style="color: #d9e6ef; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" class="prefooter-header">
                        @if(isset($email) && !empty($email))
                            Pour vous désinscrire de cette newsletter <a style="color: #fff;" href="{{ secure_url('newsletter/unsubscribe/'.$email) }}">cliquez ici</a>
                        @endif
                    </td>
                </tr>
                <tr bgcolor="0f4060"><td height="20"></td></tr>
                <tr bgcolor="0f4060">
                    <td mc:edit="copy3" align="center" style="color: #fff; line-height:18px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                        <strong>Faculté de droit</strong><br/>
                        Avenue du 1er-Mars 26<br/>
                        2000 Neuchâtel
                    </td>
                </tr>
                <tr bgcolor="0f4060"><td height="10"></td></tr>
                <tr bgcolor="0f4060">
                    <td mc:edit="copy3" align="center" style="color: #fff; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                        Droit pour le Praticien © Copyright {{ date('Y') }}
                    </td>
                </tr>
                <tr bgcolor="0f4060"><td height="20"></td></tr>
            </table>
            <!-- -------  end footer ------- -->

        </td>
    </tr>
</table>
