<?php
namespace modelTrait;

trait Pagination {
    
    function pagination($query = null, $perPage = 10, $pgntionPage = 1, $url = null)
    {
        $url =  substr(constant('CURRENT_PAGE_SELF').'&', 1);// will remove the first "?"
        $query = "SELECT COUNT(*) as `num` FROM {$query}";
        $row = mysql_fetch_array(mysql_query($query));
        $total = $row['num'];
        $adjacents = "2"; 

        $pgntionPage = ($pgntionPage == 0 ? 1 : $pgntionPage);  
        $start = ($pgntionPage - 1) * $pgntionPage;								

        $prev = $pgntionPage - 1;							
        $next = $pgntionPage + 1;
        $lastpage = ceil($total/$perPage);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if($lastpage > 1)
        {	
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li class='details'>Page $pgntionPage of $lastpage</li>";
                
            if ($lastpage < 7 + ($adjacents * 2))
            {	
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $pgntionPage)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                    $pagination.= "<li><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                }
            }
                
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($pgntionPage < 1 + ($adjacents * 2))		
                {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                        $pagination.= "<li class='dot'>...</li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=$lastpage'>$lastpage</a></li>";		
                }
                elseif($lastpage - ($adjacents * 2) > $pgntionPage && $pgntionPage > ($adjacents * 2))
                {
                        $pagination.= "<li><a href='{$url}pgntionPage=1'>1</a></li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=2'>2</a></li>";
                        $pagination.= "<li class='dot'>...</li>";
                        for ($counter = $pgntionPage - $adjacents; $counter <= $pgntionPage + $adjacents; $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                        $pagination.= "<li class='dot'>..</li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=$lastpage'>$lastpage</a></li>";		
                }
                else
                {
                        $pagination.= "<li><a href='{$url}pgntionPage=1'>1</a></li>";
                        $pagination.= "<li><a href='{$url}pgntionPage=2'>2</a></li>";
                        $pagination.= "<li class='dot'>..</li>";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                }
            }

            if ($pgntionPage < $counter - 1) { 
                    $pagination.= "<li><a href='{$url}pgntionPage=$next'>Next</a></li>";
            $pagination.= "<li><a href='{$url}pgntionPage=$lastpage'>Last</a></li>";
            } else {
                    $pagination.= "<li><a class='current'>Next</a></li>";
            $pagination.= "<li><a class='current'>Last</a></li>";
            }
            
            $pagination.= "</ul>\n";		
        }
        
        return $pagination;
    } 
    
    function paginationForQuiz($query = null, $perPage = 10, $pgntionPage = 1, $url = null)
    {
        $addUrl = $_GET['quizId'].'&uTakeId='.$_GET['uTakeId'].'&';
        $url =  '?page=quiz-onGoing&quizId='.$addUrl;// will remove the first "?"
        $query = "SELECT COUNT(*) as `num` FROM {$query}";
        $row = mysql_fetch_array(mysql_query($query));
        $total = $row['num'];
        $adjacents = "1"; 

        $pgntionPage = ($pgntionPage == 0 ? 1 : $pgntionPage);  
        $start = ($pgntionPage - 1) * $pgntionPage;								

        $prev = $pgntionPage - 1;							
        $next = $pgntionPage + 1;
        $lastpage = ceil($total/$perPage);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if($lastpage > 1)
        {	
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li class='details'>$pgntionPage of $lastpage</li>";
                
            if ($lastpage < 7 + ($adjacents * 2))
            {	
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $pgntionPage)
                        $pagination.= "<li style='"."display: none;"."'><a class='current'>$counter</a></li>";
                    else
                    $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                }
            }
                
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($pgntionPage < 1 + ($adjacents * 2))		
                {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li style='"."display: none;"."'><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                        $pagination.= "<li style='"."display: none;"."' class='dot'>...</li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$lastpage'>$lastpage</a></li>";		
                }
                elseif($lastpage - ($adjacents * 2) > $pgntionPage && $pgntionPage > ($adjacents * 2))
                {
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=1'>1</a></li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=2'>2</a></li>";
                        $pagination.= "<li style='"."display: none;"."' class='dot'>...</li>";
                        for ($counter = $pgntionPage - $adjacents; $counter <= $pgntionPage + $adjacents; $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li style='"."display: none;"."'><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                        $pagination.= "<li style='"."display: none;"."' class='dot'>..</li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$lpm1'>$lpm1</a></li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$lastpage'>$lastpage</a></li>";		
                }
                else
                {
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=1'>1</a></li>";
                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=2'>2</a></li>";
                        $pagination.= "<li style='"."display: none;"."'>..</li>";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                                if ($counter == $pgntionPage)
                                        $pagination.= "<li style='"."display: none;"."'><a class='current'>$counter</a></li>";
                                else
                                        $pagination.= "<li style='"."display: none;"."'><a href='{$url}pgntionPage=$counter'>$counter</a></li>";					
                        }
                }
            }

            if ($pgntionPage < $counter - 1) { 
                    
                    if ($prev != 0) {
                        $pagination.= "<li><a href='#' class='submitThisAnswer back' data-form-submit-url='{$url}pgntionPage=$prev'><< Back</a></li>";                        
                    }                    
                    //$pagination.= "<li><a href='{$url}pgntionPage=$next'>Next</a></li>";  
                    $pagination.= "<li><a href='#' class='submitThisAnswer continue' data-form-submit-url='{$url}pgntionPage=$next'>Continue >></a></li>"; 
            } else {
                    $pagination.= "<li><a id='lastQuestionPage' href='#' class='submitThisAnswer back' data-form-submit-url='{$url}pgntionPage=$prev'><< Back</a></li>";
                    //$pagination.= "<li><a class='current'>Continue >></a></li>";                    
            }
            
            $pagination.= "</ul>\n";		
        }
        
        $response = [];
        $response['pagination'] = $pagination;
        $response['next'] = $next;
        $response['prev'] = $prev;
        $response['last'] = $lastpage;
        $response['lastUrl'] = "{$url}pgntionPage=";
        
        return $response;
    }   
}