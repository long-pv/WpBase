<?php get_header(); ?>

<div class="search-container">
    <h1>Kết quả tìm kiếm</h1>
    <form method="get" action="<?php echo home_url(); ?>">
        <input type="text" name="s" placeholder="Nhập từ khóa..." value="<?php echo get_search_query(); ?>" required>
        <button type="submit">Tìm kiếm</button>
    </form>

    <div id="search-results">
        <?php if (have_posts()) : ?>
            <ul>
                <?php while (have_posts()) : the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>Không tìm thấy kết quả nào.</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .search-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .search-container form {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .search-container input {
        width: 70%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .search-container button {
        padding: 10px 15px;
        background: #0073aa;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .search-container ul {
        list-style: none;
        padding: 0;
    }

    .search-container li {
        margin: 10px 0;
    }

    .search-container a {
        text-decoration: none;
        color: #0073aa;
        font-weight: bold;
    }

    .search-container a:hover {
        text-decoration: underline;
    }
</style>

<?php get_footer(); ?>