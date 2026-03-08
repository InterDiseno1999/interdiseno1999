<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #f4f2f1; 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #333333; 
        }
        .wrapper { 
            width: 100%; 
            table-layout: fixed; 
            background-color: #f4f2f1; 
            padding-bottom: 40px; 
            padding-top: 40px;
        }
        .main { 
            background-color: #ffffff; 
            margin: 0 auto; 
            width: 100%; 
            max-width: 600px; 
            border-spacing: 0; 
            border-radius: 32px; 
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .header { 
            background-color: #333333; 
            padding: 40px; 
            text-align: center; 
        }
        .content { 
            padding: 40px; 
            background-color: #ffffff; 
        }
        .footer { 
            padding: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #999999; 
            text-transform: uppercase; 
            letter-spacing: 2px;
        }
        .logo-text { 
            margin: 0; 
            color: #ffffff; 
            font-size: 26px; 
            font-weight: 700; 
            letter-spacing: -1px; 
            text-decoration: none;
        }
        .logo-accent { 
            color: #C0B7B1; 
            font-weight: 300; 
        }
        .label { 
            font-size: 10px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            color: #C0B7B1; 
            margin-bottom: 8px; 
            display: block;
        }
        .value { 
            font-size: 16px; 
            margin-bottom: 25px; 
            color: #333333; 
            font-weight: 600;
        }
        .message-box { 
            background-color: #f9f8f7; 
            padding: 25px; 
            border-radius: 20px; 
            border: 1px solid #eeeeee;
            line-height: 1.6;
        }
        .divider {
            height: 1px;
            background-color: #eeeeee;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main" width="100%">
            <tr>
                <td class="header">
                    <h1 class="logo-text">InterDiseño</span></h1>
                </td>
            </tr>

            <tr>
                <td class="content">
                    <p style="font-size: 18px; font-weight: 700; margin-bottom: 30px; letter-spacing: -0.5px;">Has recibido una nueva consulta:</p>
                    
                    <span class="label">Nombre del Cliente</span>
                    <div class="value">{{ $data['name'] }}</div>

                    <span class="label">Correo Electrónico</span>
                    <div class="value">{{ $data['email'] }}</div>

                    <div class="divider"></div>

                    <span class="label">Mensaje</span>
                    <div class="message-box">
                        {!! nl2br(e($data['message'])) !!}
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    © InterDiseño SRL 1999<br>
                    Gestión de Consultas Web
                </td>
            </tr>
        </table>
    </center>
</body>
</html>