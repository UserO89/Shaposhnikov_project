<?php
class Slider {
    private $headings = [];
    private $img_folder = '';

    // Setter for headings
    public function set_headings(array $headings) {
        $this->headings = $headings;
    }

    // Setter for image folder
    public function set_img_folder(string $img_folder) {
        $this->img_folder = $img_folder;
    }


    // Method to generate slides
    public function generate_slides() {
        $result = '<section class="slides-container">';
        // Získanie zoznamu súborov obrázkov v adresári
        $img_files = glob($this->img_folder . '*.jpg');
        
        // Kontrola počtu nadpisov
        $heading_count = count($this->headings);
        
        // Prechádza cez každý obrázok
        for ($i = 0; $i < count($img_files); $i++) {
            // Začiatok divu pre snímku
            $result .= '<div class="slide fade">
                        <img src="'.$img_files[$i].'">
                        <div class="slide-text">';
            
            // Podmienka pre výpis nadpisu
            if ($heading_count == count($img_files)) {
                // Vypíše i-ty nadpis, ak je ich dostatok
                $result .= $this->headings[$i];
            } else {
                // Inak vypíše nadpis len ak sme mimo rozsahu poľa
                if ($i < $heading_count) {
                    $result .= $this->headings[$i];
                }
            }
            
            // Koniec divu pre text snímky
            $result .= '</div> 
                        </div>';
        }
        $result .= '<a id="prev" class="prev">❮</a>
        <a id="next" class="next">❯</a>
        </section>';
        return $result;
    }
}

?>