<div class="p-6 text-surface">
    <div class="bg-white shadow p-4 rounded">
        <h5 class="mb-2 text-xl font-medium leading-tight gap-4"><?php echo e($comment->meeting?->day?? "Sense data"); ?></h5>
        <p class="mb-4 text-base"><?php echo $comment->comment; ?></p>
        <p class="mb-4 text-base">Score: <?php echo e($comment->score); ?></p>
        <p class="mb-4 text-base">Autor: <?php echo e($comment->user?->name ?? "Sense nom"); ?></p>

        <?php $__currentLoopData = $comment->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="/images/<?php echo e($image->url); ?>" target="_blank">Ver imagen</a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <a href="<?php echo e(route('commentCRUD.show', ['commentCRUD' => $comment->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('commentCRUD.edit', ['commentCRUD' => $comment->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('commentCRUD.destroy', ['commentCRUD' => $comment->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\carke\Desktop\BaleartTrek\Back-BaleartTrek\baleartrek\resources\views/components/card-comment.blade.php ENDPATH**/ ?>