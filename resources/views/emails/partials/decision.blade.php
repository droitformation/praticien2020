<!-- ------- section 1 ------- -->
<tr align="center">
    <td>
        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="container-middle">
            <tr bgcolor="ffffff">
                <td>
                    <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                        <tr><td height="20"></td></tr>
                        <tr>
                            <td>
                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                                    <tr><td height="6"></td></tr>
                                    <tr>&nbsp;
                                        <td>
                                            <a target="_blank" href="{{ $decision->link }}" style="width: 130px; display: block; border-style: none !important; border: 0 !important;">
                                                <img editable="true" mc:edit="image1" width="110" height="90" border="0" style="display: block;" src="{{ secure_asset('images/image1.png') }}" alt="image1" class="section-img" />
                                            </a>
                                        </td>
                                    </tr>
                                    <tr><td height="10"></td></tr>
                                </table>

                                <table border="0" width="10" align="left" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" cellspacing="0">
                                    <tr><td height="30" width="10"></td></tr>
                                </table>

                                <table border="0" width="360" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                                    <tr>
                                        <td mc:edit="title2" style="color: #0f4060; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                            <a target="_blank" href="{{ $decision->link }}" style="color: #0f4060; font-size: 16px;text-decoration: none !important; font-weight: bold; font-family: Helvetica, Arial, sans-serif;">
                                               {{ $decision->numero }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr><td height="15"></td></tr>
                                    <tr>
                                        <td mc:edit="subtitle2" style="color: #0f4060; line-height: 20px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">

                                            <strong>{{ $decision->decision_at->formatLocalized("%d %B %Y") }}</strong><br/>
                                            {{ $decision->categorie->name }}<br/>
                                            {{ $decision->remarque }}

                                        </td>
                                    </tr>
                                    <tr><td height="15"></td></tr>
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{ url('/') }}/decision/{{ $decision->id }}/{{ $decision->publication_at->year }}"
                                               style="display: block; width: 130px;font-family: Arial, sans-serif; padding: 4px 10px; text-align: center; border-style: none !important;text-decoration: none !important; border: 0 !important;background:#9c8b6f;color:#fff;">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td height="20"></td></tr>
                    </table>
                </td>
            </tr>

        </table>
    </td>
</tr><!-- ------- end section 1 ------- -->
<tr><td height="15"></td></tr>
<tr bgcolor="#e4e4e4"><td align="center" height="1" width="600"></td></tr>
