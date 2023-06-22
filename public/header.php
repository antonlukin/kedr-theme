<?php
/**
 * The template for displaying the header
 *
 * @package kedr-theme
 * @since 2.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#48625E">
<meta name="apple-mobile-web-app-status-bar-style" content="#48625E">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header">
    <div class="header__inner">
        <a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Главная страница', 'kedr-theme' ); ?>">
            <svg class="header__logo-vertical" viewBox="0 0 59 98" xmlns="http://www.w3.org/2000/svg">
                <path fill="#34815e" fill-rule="evenodd" stroke="none" d="M 34.694199 65 C 34.652 65 34.609001 64.996597 34.565899 64.989197 L 21.0695 62.7663 C 20.7493 62.713501 20.5124 62.4715 20.4979 62.182701 C 20.483601 61.8937 20.695499 61.634102 21.009399 61.556599 L 33.123901 58.559502 L 15.9644 55.0214 C 15.6315 54.952801 15.403 54.6805 15.4245 54.377399 C 15.4459 54.074299 15.7105 53.829399 16.050501 53.797901 L 38.7798 51.706001 L 0.699702 51.706001 C 0.331386 51.706001 0.026165 51.452599 0.001584 51.126301 C -0.022997 50.799999 0.241213 50.5126 0.606243 50.4688 L 47.874001 44.8088 L 6.36522 44.8088 C 6.00624 44.8088 5.70562 44.5676 5.66908 44.250702 C 5.63267 43.933498 5.87203 43.643398 6.22352 43.578899 L 38.197201 37.7075 L 9.19818 37.7075 C 8.83618 37.7075 8.53398 37.462399 8.50125 37.1423 C 8.46865 36.821999 8.71643 36.5326 9.07265 36.474899 L 33.1077 32.584 L 16.4002 31.792404 C 16.0495 31.775696 15.7668 31.530701 15.7399 31.219398 C 15.713 30.908302 15.9501 30.627701 16.2939 30.563499 L 35.141102 27.052795 L 20.7409 25.140305 C 20.401199 25.095299 20.1486 24.838104 20.144501 24.533203 C 20.1404 24.228401 20.386 23.965897 20.724199 23.913605 L 32.9091 22.029701 L 18.127501 21.323097 C 17.7889 21.306702 17.511999 21.077103 17.470699 20.778198 C 17.4293 20.479202 17.635401 20.196899 17.9597 20.108299 L 32.108299 16.2481 L 18.2052 16.9552 C 17.861401 16.9711 17.5583 16.768295 17.4828 16.471802 C 17.407301 16.1754 17.584101 15.874199 17.9009 15.759499 L 30.496401 11.1959 L 26.824499 11.1959 C 26.5077 11.1959 26.2302 11.006699 26.1485 10.734901 C 26.0667 10.462898 26.200899 10.176102 26.4755 10.035698 L 29.9835 8.242798 L 25.3836 8.242798 C 24.997101 8.242798 24.683901 7.964699 24.683901 7.621399 C 24.683901 7.278099 24.997101 7 25.3836 7 L 32.602001 7 C 32.918999 7 33.196301 7.189117 33.278099 7.460983 C 33.359798 7.732849 33.2257 8.019638 32.951 8.160057 L 29.443199 9.952942 L 34.0639 9.952942 C 34.398499 9.952942 34.6861 10.163399 34.750702 10.454803 C 34.8148 10.7463 34.637901 11.037697 34.328098 11.149803 L 22.3188 15.500999 L 37.8009 14.713501 C 38.152802 14.697098 38.467098 14.914497 38.5298 15.224098 C 38.592201 15.5336 38.384899 15.835602 38.046501 15.928101 L 22.1334 20.269798 L 39.137699 21.082802 C 39.493 21.0998 39.7775 21.350998 39.798698 21.666595 C 39.819698 21.982201 39.570702 22.261597 39.2202 22.315598 L 25.2253 24.479202 L 39.203499 26.335701 C 39.538502 26.380096 39.7896 26.631302 39.799599 26.931999 C 39.809399 27.232903 39.575199 27.496597 39.243801 27.558502 L 21.8183 30.804504 L 39.137501 31.624901 C 39.491901 31.6418 39.775902 31.891502 39.798401 32.2061 C 39.820999 32.520699 39.574799 32.8004 39.2257 32.856903 L 16.9391 36.464802 L 45.037399 36.464802 C 45.3964 36.464802 45.696999 36.705799 45.733398 37.0229 C 45.769901 37.340099 45.530399 37.6301 45.1791 37.694698 L 13.2054 43.565899 L 58.300301 43.565899 C 58.668598 43.565899 58.973801 43.819401 58.998402 44.145699 C 59.022999 44.472 58.758801 44.759499 58.393799 44.803101 L 11.1263 50.4632 L 52.319801 50.4632 C 52.6922 50.4632 52.999401 50.722401 53.0186 51.052601 C 53.0378 51.3829 52.762402 51.668598 52.391998 51.702801 L 20.357 54.651199 L 36.110901 57.899399 C 36.422298 57.963501 36.645199 58.2071 36.6521 58.491199 C 36.659199 58.775101 36.448399 59.027199 36.140202 59.103199 L 24.2959 62.033699 L 34.820999 63.7672 C 35.200901 63.829899 35.4519 64.154297 35.3815 64.4916 C 35.318901 64.790901 35.024899 64.999702 34.694199 65"></path>
                <path fill="#34815e" fill-rule="evenodd" stroke="none" d="M 29.312401 74 C 28.999599 74 28.716801 73.804604 28.6436 73.516296 C 28.560699 73.188904 26.616301 65.451797 26.9289 61.408798 C 27.0802 59.448101 27.079599 44.757999 26.927099 30.588402 C 26.741301 13.320602 26.3974 1.907829 26.029499 0.803703 C 25.919901 0.474335 26.1252 0.12648 26.4883 0.026848 C 26.8505 -0.072777 27.2346 0.113457 27.3445 0.443085 C 28.315001 3.35656 28.5665 58.035 28.298901 61.495998 C 28.000999 65.3536 29.9625 73.158897 29.982401 73.237198 C 30.0674 73.572701 29.8365 73.906898 29.466801 73.984001 C 29.415199 73.994797 29.3633 74 29.312401 74"></path>
                <path fill="#34815e" fill-rule="evenodd" stroke="none" d="M 50.297401 75 L 7.70259 75 C 7.31453 75 7 74.776299 7 74.500099 C 7 74.223801 7.31453 74 7.70259 74 L 50.297401 74 C 50.6856 74 51 74.223801 51 74.500099 C 51 74.776299 50.6856 75 50.297401 75"></path>
                <path fill="#262626" fill-rule="evenodd" stroke="none" d="M 4.55927 88.505699 L 2.1247 88.505699 L 2.1247 94 L 0 94 L 0 81 L 2.1247 81 L 2.1247 86.494202 L 4.6036 86.494202 L 8.41038 81 L 10.6901 81 L 6.24134 87.2547 L 11 94 L 8.49905 94 L 4.55927 88.505699 Z"></path>
                <path fill="#262626" fill-rule="evenodd" stroke="none" d="M 17.420601 83.955597 C 16.7162 84.628304 16.303301 85.509499 16.1821 86.5989 L 23.9093 86.5989 C 23.7878 85.525703 23.375099 84.648598 22.6707 83.967598 C 21.966101 83.286903 21.091299 82.946198 20.0457 82.946198 C 19.000299 82.946198 18.125299 83.282799 17.420601 83.955597 M 25.9545 88.256699 L 16.181999 88.256699 C 16.3183 89.378304 16.7843 90.279503 17.5797 90.960197 C 18.3752 91.641502 19.363899 91.981598 20.545401 91.981598 C 21.985001 91.981598 23.1437 91.4692 24.0228 90.443604 L 25.227301 91.933502 C 24.6819 92.6064 24.0037 93.119202 23.193199 93.471397 C 22.3825 93.823997 21.477301 94 20.4774 94 C 19.2047 94 18.0758 93.723701 17.091101 93.170998 C 16.105801 92.618401 15.3446 91.845596 14.807 90.852303 C 14.2691 89.859001 14 88.737602 14 87.4879 C 14 86.254501 14.2616 85.141098 14.7844 84.147697 C 15.3071 83.154701 16.026501 82.381599 16.9433 81.829002 C 17.8598 81.276299 18.893801 81 20.0455 81 C 21.197001 81 22.223499 81.276299 23.124901 81.829002 C 24.026501 82.381599 24.7309 83.154701 25.2388 84.147697 C 25.746 85.141098 26 86.278603 26 87.560097 C 26 87.736603 25.984699 87.968498 25.9545 88.256699"></path>
                <path fill="#262626" fill-rule="evenodd" stroke="none" d="M 54.967201 91.1092 C 55.557301 90.744003 56.023602 90.231003 56.365898 89.569901 C 56.708401 88.909302 56.879799 88.151497 56.879799 87.296097 C 56.879799 86.441399 56.708401 85.683502 56.365898 85.022499 C 56.023602 84.362 55.557301 83.852898 54.967201 83.495003 C 54.3769 83.137497 53.7103 82.958801 52.966999 82.958801 C 52.2383 82.958801 51.579201 83.141701 50.988998 83.506699 C 50.398899 83.8722 49.932301 84.381302 49.590199 85.034103 C 49.247601 85.687103 49.076401 86.441399 49.076401 87.296097 C 49.076401 88.151497 49.243801 88.909302 49.578999 89.569901 C 49.9142 90.231003 50.380501 90.744003 50.978001 91.1092 C 51.575298 91.474403 52.2383 91.657097 52.966999 91.657097 C 53.7103 91.657097 54.3769 91.474403 54.967201 91.1092 M 56.158501 81.792801 C 57.047001 82.321503 57.743099 83.060097 58.245701 84.008102 C 58.7486 84.956703 59 86.052696 59 87.296097 C 59 88.540199 58.7486 89.6399 58.245701 90.596199 C 57.743099 91.5522 57.047001 92.2948 56.158501 92.823196 C 55.269299 93.351898 54.263802 93.615898 53.142101 93.615898 C 52.311298 93.615898 51.549702 93.445099 50.858002 93.102898 C 50.1656 92.761101 49.578999 92.263397 49.098202 91.610603 L 49.098202 98 L 47 98 L 47 81.116501 L 49.010799 81.116501 L 49.010799 83.075302 C 49.4772 82.391502 50.0672 81.874496 50.781399 81.524696 C 51.495201 81.174797 52.282101 81 53.142101 81 C 54.263802 81 55.269299 81.264603 56.158501 81.792801"></path>
                <path fill="#262626" fill-rule="evenodd" stroke="none" d="M 31.885 92.045799 L 36.118 83.6492 L 40.174801 92.045799 L 31.885 92.045799 Z M 35.203602 81 L 29 94 L 43 94 L 37.082901 81 L 35.203602 81 Z"></path>
            </svg>

            <svg class="header__logo-horizontal" viewBox="0 0 104 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.6409 33C21.6191 33.0001 21.5974 32.9985 21.5759 32.995L14.7129 31.883C14.5499 31.857 14.4299 31.736 14.4229 31.591C14.4149 31.447 14.5229 31.317 14.6829 31.278L20.8429 29.78L12.1179 28.01C11.9479 27.976 11.8319 27.84 11.8429 27.689C11.8529 27.537 11.9879 27.415 12.1609 27.399L23.7189 26.353H4.35586C4.16886 26.353 4.01286 26.226 4.00086 26.063C3.98786 25.9 4.12286 25.756 4.30786 25.734L28.3429 22.904H7.23686C7.05386 22.904 6.90086 22.784 6.88286 22.625C6.86386 22.467 6.98586 22.322 7.16486 22.289L23.4219 19.354H8.67687C8.49287 19.354 8.33887 19.231 8.32287 19.071C8.30587 18.911 8.43286 18.766 8.61286 18.737L20.8339 16.792L12.3389 16.396C12.1609 16.388 12.0169 16.266 12.0029 16.11C11.9899 15.954 12.1099 15.814 12.2849 15.782L21.8679 14.026L14.5459 13.07C14.3729 13.048 14.2449 12.919 14.2429 12.767C14.2409 12.614 14.3659 12.483 14.5379 12.457L20.7329 11.515L13.2169 11.162C13.0449 11.153 12.9039 11.039 12.8829 10.889C12.8629 10.739 12.9669 10.599 13.1319 10.554L20.3259 8.624L13.2559 8.978C13.0819 8.986 12.9279 8.884 12.8899 8.736C12.8509 8.588 12.9409 8.437 13.1019 8.38L19.5069 6.098H17.6399C17.4789 6.098 17.3369 6.003 17.2959 5.868C17.2539 5.731 17.3229 5.588 17.4619 5.518L19.2459 4.621H16.9059C16.7099 4.621 16.5509 4.482 16.5509 4.311C16.5509 4.139 16.7109 4 16.9069 4H20.5769C20.7379 4 20.8789 4.095 20.9209 4.23C20.9629 4.366 20.8939 4.51 20.7549 4.58L18.9709 5.476H21.3209C21.4909 5.476 21.6369 5.582 21.6699 5.727C21.7019 5.873 21.6119 6.019 21.4549 6.075L15.3489 8.25L23.2209 7.857C23.3999 7.849 23.5599 7.957 23.5909 8.112C23.6229 8.267 23.5179 8.418 23.3459 8.464L15.2539 10.634L23.9009 11.041C24.0809 11.05 24.2259 11.176 24.2369 11.333C24.2469 11.491 24.1209 11.631 23.9419 11.658L16.8259 12.74L23.9339 13.668C24.1039 13.69 24.2319 13.816 24.2369 13.966C24.2419 14.116 24.1229 14.248 23.9539 14.279L15.0939 15.902L23.8999 16.312C24.0799 16.321 24.2249 16.446 24.2359 16.603C24.2479 16.76 24.1229 16.9 23.9459 16.928L12.6119 18.732H26.8999C27.0829 18.732 27.2359 18.852 27.2539 19.012C27.2729 19.17 27.1509 19.315 26.9719 19.347L10.7149 22.283H33.6449C33.8309 22.283 33.9869 22.41 33.9989 22.573C34.0119 22.736 33.8769 22.88 33.6919 22.902L9.65687 25.732H30.6029C30.7929 25.732 30.9489 25.862 30.9589 26.026C30.9689 26.191 30.8289 26.334 30.6399 26.351L14.3509 27.826L22.3609 29.45C22.5199 29.482 22.6329 29.604 22.6369 29.746C22.6399 29.888 22.5329 30.014 22.3769 30.052L16.3539 31.517L21.7059 32.384C21.8989 32.415 22.0259 32.577 21.9909 32.746C21.9589 32.896 21.8089 33 21.6409 33Z" fill="#34815E"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.6559 37C18.4999 37 18.3579 36.902 18.3219 36.758C18.2799 36.594 17.3079 32.726 17.4639 30.704C17.5399 29.724 17.5399 22.379 17.4639 15.294C17.3709 6.66 17.1989 0.954003 17.0139 0.402003C16.9599 0.237003 17.0629 0.0630033 17.2439 0.0130033C17.4249 -0.0369967 17.6169 0.0570033 17.6719 0.222003C18.1579 1.678 18.2829 29.018 18.1489 30.748C17.9999 32.677 18.9809 36.579 18.9909 36.618C19.0339 36.786 18.9179 36.953 18.7329 36.992C18.7075 36.9973 18.6817 37 18.6559 37Z" fill="#34815E"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M28.649 38H7.35C7.157 38 7 37.776 7 37.5C7 37.224 7.157 37 7.351 37H28.65C28.844 37 29.001 37.224 29.001 37.5C29.001 37.776 28.843 38 28.649 38Z" fill="#34815E"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M45.5593 21.5057H43.1247V27H41V14H43.1247V19.4942H45.6036L49.4104 14H51.6901L47.2413 20.2547L52 27H49.4991L45.5593 21.5057Z" fill="#262626"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M58.4206 16.9556C57.7162 17.6283 57.3033 18.5095 57.1821 19.5989H64.9093C64.7878 18.5257 64.3751 17.6486 63.6707 16.9676C62.9661 16.2869 62.0913 15.9462 61.0457 15.9462C60.0003 15.9462 59.1253 16.2828 58.4206 16.9556M66.9545 21.2567H57.182C57.3183 22.3783 57.7843 23.2795 58.5797 23.9602C59.3752 24.6415 60.3639 24.9816 61.5454 24.9816C62.985 24.9816 64.1437 24.4692 65.0228 23.4436L66.2273 24.9335C65.6819 25.6064 65.0037 26.1192 64.1932 26.4714C63.3825 26.824 62.4773 27 61.4774 27C60.2047 27 59.0758 26.7237 58.0911 26.171C57.1058 25.6184 56.3446 24.8456 55.807 23.8523C55.2691 22.859 55 21.7376 55 20.4879C55 19.2545 55.2616 18.1411 55.7844 17.1477C56.3071 16.1547 57.0265 15.3816 57.9433 14.829C58.8598 14.2763 59.8938 14 61.0455 14C62.197 14 63.2235 14.2763 64.1249 14.829C65.0265 15.3816 65.7309 16.1547 66.2388 17.1477C66.746 18.1411 67 19.2786 67 20.5601C67 20.7366 66.9847 20.9685 66.9545 21.2567" fill="#262626"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M95.9672 24.1092C96.5573 23.744 97.0236 23.231 97.3659 22.5699C97.7084 21.9093 97.8798 21.1515 97.8798 20.2961C97.8798 19.4414 97.7084 18.6835 97.3659 18.0225C97.0236 17.362 96.5573 16.8529 95.9672 16.495C95.3769 16.1375 94.7103 15.9588 93.967 15.9588C93.2383 15.9588 92.5792 16.1417 91.989 16.5067C91.3989 16.8722 90.9323 17.3813 90.5902 18.0341C90.2476 18.6871 90.0764 19.4414 90.0764 20.2961C90.0764 21.1515 90.2438 21.9093 90.579 22.5699C90.9142 23.231 91.3805 23.744 91.978 24.1092C92.5753 24.4744 93.2383 24.6571 93.967 24.6571C94.7103 24.6571 95.3769 24.4744 95.9672 24.1092M97.1585 14.7928C98.047 15.3215 98.7431 16.0601 99.2457 17.0081C99.7486 17.9567 100 19.0527 100 20.2961C100 21.5402 99.7486 22.6399 99.2457 23.5962C98.7431 24.5522 98.047 25.2948 97.1585 25.8232C96.2693 26.3519 95.2638 26.6159 94.1421 26.6159C93.3113 26.6159 92.5497 26.4451 91.858 26.1029C91.1656 25.7611 90.579 25.2634 90.0982 24.6106V31H88V14.1165H90.0108V16.0753C90.4772 15.3915 91.0672 14.8745 91.7814 14.5247C92.4952 14.1748 93.2821 14 94.1421 14C95.2638 14 96.2693 14.2646 97.1585 14.7928" fill="#262626"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M72.885 25.0458L77.118 16.6492L81.1748 25.0458H72.885ZM76.2036 14L70 27H84L78.0829 14H76.2036Z" fill="#262626"></path>
            </svg>
        </a>

        <div class="header__navbar">
            <?php
            if ( has_nav_menu( 'main' ) ) :
                wp_nav_menu(
                    array(
                        'theme_location' => 'main',
                        'depth'          => 1,
                        'echo'           => true,
                        'items_wrap'     => '<ul class="header__navbar-menu menu">%3$s</ul>',
                        'container'      => false,
                    )
                );
            endif;
            ?>

            <div class="header__navbar-service">
                <?php
                if ( has_nav_menu( 'social' ) ) :
                    wp_nav_menu(
                        array(
                            'theme_location' => 'social',
                            'depth'          => 1,
                            'echo'           => true,
                            'items_wrap'     => '<ul class="header__social social">%3$s</ul>',
                            'container'      => false,
                        )
                    );
                endif;
                ?>

                <a href="<?php echo esc_url( home_url( '/search/' ) ); ?>" class="header__search">
                    <?php
                    printf(
                        '<svg class="header__search-icon"><use xlink:href="%s"></use></svg>',
                        esc_url( get_template_directory_uri() . '/assets/images/icons-sprite.svg#kedr-icon-search' )
                    );
                    ?>
                </a>
            </div>
        </div>

        <?php
        printf(
            '<a href="%s" class="header__donate button">%s</a>',
            esc_url( home_url( '/donate/' ) ),
            esc_html__( 'Поддержать', 'kedr-theme' )
        );
        ?>

        <button class="header__toggle" id="toggle-menu" aria-label="<?php esc_attr_e( 'Меню сайта', 'kedr-theme' ); ?>">
            <span class="header__toggle-line"></span>
            <span class="header__toggle-line"></span>
            <span class="header__toggle-line"></span>
        </button>
    </div>
</header>
