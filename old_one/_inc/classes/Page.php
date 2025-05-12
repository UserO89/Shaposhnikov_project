<?php

    class Page{
        private $page_name;

        public function set_page_name($page_name)
        {
            $this->page_name = $page_name;
        }

        function add_stylesheet() {
            $result =  '<link rel="stylesheet" href="../assets/css/style.css">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
        
           //$page_name = basename($_SERVER["SCRIPT_NAME"], '.php');
            
            switch($this->page_name){
                case 'home':
                    $result .= '<link rel="stylesheet" href="../assets/css/slider.css">';
                    break;
                    
                case 'kontakt':
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/form.css">';
                    break;

                case 'kontakt-update':
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/form.css">';
                    break;
                
                case 'register':
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/form.css">';
                    break;
                
                case 'login':
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/form.css">';
                    break;
               
                case 'portfolio':
                    $result .= '<link rel="stylesheet" href="../assets/css/portfolio.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    break;
                case 'qna':
                    $result .= '<link rel="stylesheet" href="../assets/css/accordion.css">';
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    break;
                case 'thankyou':
                    $result .= '<link rel="stylesheet" href="../assets/css/banner.css">';
                    break;
            }
            return $result;
        }

        function add_scripts(){
            $result = '<script src="../assets/js/menu.js"></script>';
            //$page_name = basename($_SERVER["SCRIPT_NAME"],'.php');
            switch($this->page_name){
            case 'home':
                $result .= '<script src="../assets/js/slider.js"></script>';
                break;
            case 'qna':
                $result .= '<script src="../assets/js/accordion.js"></script>';
                break;  
            }
            return $result;   
        }
        
        function redirect_homepage(){
            header("Location: templates/home.php");
            die("Nepodarilo sa nájsť Domovskú stránku");
        }

    }

?>