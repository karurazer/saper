<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="karurazer">
    <title>Saper</title>
</head>
<body>
    <?php
    class Cell{
        public $is_mine = false;
        public $is_open = false;
        public $row;
        public $column;
        public $mines_around = 0;
        private $max_mines_around = 5;
        function __construct($column, $row){
            $this->column=$column;
            $this->row=$row;
        }
        function can_be_mine(){
            if(!$this->is_mine && $this->mines_around <= $this->max_mines_around){
                return true;
            }else{
                return false;
            }
        }
        function plus_neighbor(){
            $this->mines_around++;
        }
        
        function set_bomb(){
            $this->is_mine = true;
        }
        function show(){
            if ($this->is_open){
                if($this->is_mine){
                    echo '+ ';
                }else{
                    echo $this->mines_around . ' ';
                }
                
            }else{
                echo '+ ';
            }
            }
        
            
          
        
    }
     
    class Minesweeper{
        private $columns;
        private $rows;
        private $size;
        private $bombs;
        private $board = [];
        function __construct($columns = 8, $rows = 8, $bombs=20){
            
            $this->columns = $columns;
            $this->rows = $rows;
            $this->size = $this->rows * $this->columns;
            $this->bombs = $bombs;
            
            for ($j=0;$j<$this->rows;$j++){
                $line=[];
                for ($i=0; $i < $this->columns; $i++) { 
                    $line[] = new Cell($i, $j);
                }
                $this->board[] = $line;
            }
            $this->place_mines();
        }
        
        private function place_mines(){
            for ($i=0; $i < $this->bombs; $i++) { 
                $column = random_int(0, $this->columns - 1);
                $row = random_int(0, $this->rows - 1);
                if ($this->board[$row][$column]->can_be_mine()){
                    $this->board[$row][$column]->set_bomb();
                    $this->add_neighbors_mines($row, $column);
                }
                else{
                    $i--;
                }
                
            }
        }
        function get_neighbors($row, $column){
            $neigbors = [];
            if ($row > 0){
                $neigbors[] = $this->board[$row - 1][$column];
                if ($column != $this->columns - 1){
                    $neigbors[] = $this->board[$row - 1][$column + 1];
                }
                if ($column > 0){
                    $neigbors[] = $this->board[$row - 1][$column - 1];
                }
            }
            if ($row != $this->rows - 1){
                $neigbors[] = $this->board[$row + 1][$column];
                if ($column != $this->columns - 1){
                    $neigbors[] = $this->board[$row + 1][$column + 1];
                }
                if ($column > 0){
                    $neigbors[] = $this->board[$row + 1][$column - 1];
                }
            }
            if ($column != $this->columns - 1){
                $neigbors[] = $this->board[$row][$column + 1];
            }
            if ($column > 0){
                $neigbors[] = $this->board[$row][$column - 1];
            }
            return $neigbors;
        }
        private function add_neighbors_mines($row, $column){
            foreach($this->get_neighbors($row, $column) as $neigbor){
                $neigbor->plus_neighbor();
            }
        }
        function open_empty_cells(){
            foreach($this->board as $line){
                foreach($line as $cell){
                    if ($cell->mines_around == 0 && !$cell->is_mine){
                        $cell->is_open = true;
                        foreach($this->get_neighbors($cell->row, $cell->column) as $elem){
                            $elem->is_open = true;
                        }   
                    }   
                }
            }
        }
        function show_board(){
            $this->open_empty_cells();
            foreach($this->board as $line){
                foreach($line as $cell){
                        $cell->show();    
                    }
                    echo '<br>';
                }
            }
    }
$a = new Minesweeper();

$a->show_board();
    ?>
</body>
</html>