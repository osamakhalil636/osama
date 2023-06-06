<!doctype html>

<title>my website</title>
<link rel="stylesheet" href="/app.css">
<body>
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article>
            <?php echo $post; ?>

        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
<?php /**PATH C:\xampp\htdocs\web\abood-me\resources\views/posts.blade.php ENDPATH**/ ?>