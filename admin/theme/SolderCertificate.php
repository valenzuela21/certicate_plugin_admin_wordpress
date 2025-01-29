<?php

namespace admin\theme;

use Xbox;

class SolderCertificate
{
    public static function content()
    {
        $option_value = get_option('config_admin_cetificate_soldador');

        if (is_serialized($option_value)) {
            $option = unserialize($option_value);
        } else {
            $option = $option_value;
        }
        $title_certificate = $option_value['title-certificate'];
        $description_certificate = $option_value['description-certicate'];
        $sub_description_certificate = $option_value['sub-description-certicate'];
        $logo_business = $option_value['logo-business'];
        $signal_one = $option_value['signal-one'];
        $signal_two = $option_value['signal-two'];

        return '<style>
   
        .certificate {
            font-family: "Arial", sans-serif;
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 5px solid #2c3e50;
            background-color: #ffffff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        
        .certificate .image_logo {
               width: 85px;
               margin: 0 auto;
        }
        
        .certificate .signal {
               width: 150px;
        }

        .certificate h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .certificate h2 {
            font-size: 1.5rem;
            margin: 10px 0;
            color: #16a085;
        }

        .certificate p {
            font-size: 1rem;
            margin: 20px 0;
            color: #7f8c8d;
        }

        .certificate .recipient {
            font-size: 1.8rem;
            font-weight: bold;
            color: #34495e;
            margin: 20px 0;
        }

        .certificate .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .certificate .signature div {
            text-align: center;
        }

        .certificate .signature div p {
            margin: 10px 0 0;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .certificate {
                padding: 15px;
            }

            .certificate h1 {
                font-size: 2rem;
            }

            .certificate h2 {
                font-size: 1.2rem;
            }
        }
    </style>

    <div id="certificate" class="certificate">
        <h1>' . $title_certificate . '</h1>
        <p>' . $description_certificate . '</p>
        <div class="recipient"></div>
        <p>' . $sub_description_certificate . '</p>
        <h2 class="course"></h2>
        <h3 class="level"></h3>
       
        <div class="signature">
            <div>
            <img class="signal" src="' . $signal_one . '" />
                <hr style="width: 150px; border: 1px solid #2c3e50;">
                <p>' . __('Firma Administrativa', 'soldador-admin') . '</p>
            </div>
            <div>
             <img class="image_logo" src="' . $logo_business . '" />
             <p class="date"></p>
            </div>
            <div>
            <img class="signal" src="' . $signal_two . '" />
                <hr style="width: 150px; border: 1px solid #2c3e50;">
               <p>' . __('Firma Directivos', 'soldador-admin') . '</p>
            </div>
        </div>
    </div>
';
    }

}