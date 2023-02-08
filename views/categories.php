<div class="page-info">
    <div class="page-header">
        <h2>Категории</h2>
    </div>
    
    <?php
        $query = mysqli_query($con, 
        "SELECT * FROM categories");

        if(mysqli_num_rows($query)>0){
            while($categ = mysqli_fetch_assoc($query)){
    ?>
                <a href="?cat_id=<?=$categ['id']?>" class="list-item"><?=$categ['name']?></a>
    <?php
            }
        }
    ?>
    
</div>