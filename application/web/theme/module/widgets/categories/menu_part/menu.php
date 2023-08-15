

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b>
        <?= $category['name']?>
    </a>
    <?php if( isset($category['childs']) ): ?>

        <ul>

            <?= $this->getMenuHtml($category['childs'])?>

        </ul>

    <?php endif;?>
</li>