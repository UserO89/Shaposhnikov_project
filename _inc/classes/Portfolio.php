<?php

    class Portfolio extends Database{

        private $db;

        public function __construct(){
            $this->db = $this->db_connection();        
        }

        public function select(){
            try{
                $db_query = "SELECT * FROM portfolio";
                $query =  $this->db->query($db_query);
                $portfolio = $query->fetchAll();
                return $portfolio;

            }catch(PDOException $e){
                echo($e->getMessage());
            }   
        }

        function get_portfolio(){
            $portfolio = $this->select();
            $result = '';
            for ($i = 0; $i < count($portfolio); $i++) {
                $temp_i = $i + 1;
                if ($temp_i % 4 == 1) {
                    $result.= '<div class="row">';
                }
    
                $result.= '<div class="col-25 portfolio text-white text-center" style="background-image: url(\''.$portfolio[$i]->image.'\');">';
                $result.= '<a href="">'.$portfolio[$i]->name.'</a>';
                $result.= '</div>';
    
                if ($temp_i % 4 == 0 || $temp_i == count($portfolio)) {
                    $result.= '</div>'; // Close row after every four items or at the end
                }
            }
            return $result;
        }

        public function select_single(){
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
                try{
                    $db_query = "SELECT * FROM portfolio WHERE id = ?";
                    $query = $this->db->prepare($db_query);
                    $query->execute([$id]);
                    $portfolio = $query->fetch(); // Using fetch() as we expect only one row
                    if($portfolio) {
                        return $portfolio;
                    }else {
                        header("HTTP/1.0 400 Bad Request");
                        header("Location: 404.php");
                        die();
                    }
                } catch(PDOException $e){
                    echo($e->getMessage());
                } 

            } else {
                // id neexistuje alebo nie je validne
                header("HTTP/1.0 400 Bad Request");
                header("Location: 404.php");
                die();
            }
        }
        


    }
?>