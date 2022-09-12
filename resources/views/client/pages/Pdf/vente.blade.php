<!DOCTYPE html
    PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='https://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

<body style='font-family:Tahoma;font-size:12px;color: #333333;background-color:#FFFFFF; height:250px ;  '>
    <table align='center' border='0' cellpadding='0' cellspacing='0' style='height:250px; width:595px;font-size:12px;'>
        <tr>
            <td valign='top'>
                <table width='100%' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td valign='bottom' width='50%' height='50'>
                            <div align='left'>
                                Nom de la boutique : {{ $vente->Nom }} <br>
                                Addresse de la boutique : {{ $vente->Adresse }} <br>
                                Site-Web de la boutique : {{ $vente->Site }} <br>
                                Mail de la boutique : {{ $vente->Email }}
                            </div><br />
                        </td>

                        <td width='50%'>&nbsp;</td>
                    </tr>
                </table>
                Destinataire : <br /><br />
                <table width='100%' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td valign='top' width='50%' style='font-size:12px;'>
                            @if ($vente->ClientId > 0)
                                @foreach ($personnes as $itemClient)
                                    @if ($itemClient->id == $vente->ClientId)
                                        Nom : <strong>
                                            {{ $itemClient->Nom }}
                                        </strong> <br>
                                        Prénom : <strong>
                                            {{ $itemClient->Prenom }}
                                        </strong> <br>
                                        Adresse : <strong>
                                            {{ $itemClient->Adresse }}
                                        </strong> <br>
                                        Email : <strong>
                                            {{ $itemClient->Nom }}
                                        </strong> <br>
                                        {{ $itemClient->Email }}
                                    @endif
                                @endforeach
                            @else
                                Pas de client
                            @endif
                        </td>
                        <td valign='top' width='50%' style='font-size:12px;'>Date de la vente :
                            {{ $vente->DateVente }}<br />
                        </td>

                    </tr>
                </table>
                <table width='100%' height='100' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td>
                            <div align='center' style='font-size: 14px;font-weight: bold;'>Facture {{ $vente->id }}
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="center" width='100%' colspan="3">
                    <thead>
                        <tr>
                            <th class="text-center">Article</th>
                            <th class="text-center">Catégorie</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-center">Prix article</th>
                            <th class="text-center">Réduction</th>
                            <th class="text-center">Prix total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($item = 0; $item < count($info); $item++)
                            <tr class="text-center">
                                <td class="text-center" align="center">{{ $info[$item]['article'] }}</td>
                                <td class="text-center" align="center">{{ $info[$item]['categorie'] }} </td>
                                <td class="text-center" align="center">{{ $info[$item]['quantite'] }} </td>
                                <td class="text-center" align="center">{{ $info[$item]['Prix'] }} fcfa </td>
                                <td class="text-center" align="center">{{ $info[$item]['Reduction'] }} % </td>
                                <td class="text-center" align="center">{{ $info[$item]['Total'] }} fcfa </td>

                            </tr>
                        @endfor
                    </tbody>
                    <tfoot class="mt-5">
                        <tr>
                            <td colspan="2" align="center">Total</td>
                            <td align="center"> {{ $vente->Quantite }} </td>
                            <td align="center"></td>
                            <td align="center"> {{ $vente->Reduction }} %</td>
                            <td align="center">{{ $vente->PrixTotal }} fcfa</td>
                        </tr>
                    </tfoot>
                </table>
                <table width='100%' cellspacing='0' cellpadding='2'>
                    <tr>
                        <td width='33%' style='border-top:double medium #CCCCCC;font-size:12px;' valign='top'>
                            <b>{{ $boutique->Nom }}</b><br />
                            {{ $boutique->Site }}<br />

                        </td>
                        <td width='33%' style='border-top:double medium #CCCCCC; font-size:12px;' align='center'
                            valign='top'>
                            {{ $boutique->Adresse }}<br />
                            {{ $boutique->Email }}<br />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
