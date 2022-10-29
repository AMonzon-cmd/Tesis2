<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <!--[if mso]>
    <xml><o:officedocumentsettings><o:pixelsperinch>96</o:pixelsperinch></o:officedocumentsettings></xml>
  <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">
    <style>
.hover-underline:hover {
  text-decoration: underline !important;
}
@media (max-width: 600px) {
  .sm-w-full {
    width: 100% !important;
  }
  .sm-px-24 {
    padding-left: 24px !important;
    padding-right: 24px !important;
  }
  .sm-py-32 {
    padding-top: 32px !important;
    padding-bottom: 32px !important;
  }
}
</style>
</head>
<body style="margin: 0; width: 100%; padding: 0; word-break: break-word; -webkit-font-smoothing: antialiased;">
    <div style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: none;">This is an invoice for your purchase on undefined. Please submit payment by undefined</div>
  <div role="article" aria-roledescription="email" aria-label="" lang="en" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
    <table style="width: 100%; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center" style="mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
          <table class="sm-w-full" style="width: 600px;" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
            </tr>
              <tr>
                <td align="center" class="sm-px-24" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                  <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td class="sm-px-24" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hey</p>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">{{$pago->cliente->nombre}}</p>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px;">
                          Gracias por realizar el pago en nuestra plataforma.
                        </p>
                        <table style="width: 100%;" role="presentation">
                          <tr>
                            <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding: 16px; font-size: 16px;">
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                    <strong>Fecha de pago:</strong> {{$pago->created_at}}
                                  </td>
                                  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                    <strong>NroPago :</strong> #{{$pago->id}}
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <table style="width: 100%; border: 1px solid; border-collapse: collapse;" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td colspan="2" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; border: 1px solid;">
                              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <th align="left" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px; border: 1px solid;">
                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-left:4px;">Servicio</p>
                                  </th>
                                  <th align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px; border: 1px solid;">
                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">Monto</p>
                                  </th>
                                </tr>
                                <tr>
                                  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 80%; padding-top: 10px; padding-bottom: 10px; font-size: 16px; border: 1px solid; padding-left:4px;">
                                    {{$pago->servicio->nombre}}
                                  </td>
                                  <td align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 20%; text-align: center; font-size: 16px; border: 1px solid;">{{$pago->moneda->simbolo . ' ' . $pago->monto . '  '}}</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>

                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;">
                          Con este pago generaste <strong>{{$pago->puntaje_generado}} puntos</strong> canjeables por productos en nuestra plataforma.
                        </p>
                        <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;">
                          Saludos,
                          <br>El equipo de Payday
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            <tr>
  <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 20px;"></td>
</tr>

          </table>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>

