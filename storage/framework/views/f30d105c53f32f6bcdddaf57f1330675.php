<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <!-- Le he cambiado el nombre porque tenia que limpiar datos por nomenclaturas -->
        <?php $ip = $interestingPlace ?? $interesting_place ?? null; ?>
        <h5 class="mb-2 text-xl font-medium leading-tight gap-4"><?php echo e($ip->name); ?></h5>
        <p class="mb-4 text-base">Id: <?php echo e($ip->id); ?></p>
        <p class="mb-4 text-base">Id de Place Type: <?php echo e($ip->place_type_id); ?></p>
        <p class="mb-4 text-sm">Ubicació: <?php echo e($ip->gps); ?></p>
        <p class="mb-4 text-sm">Created at: <?php echo e($ip->created_at); ?></p>
        <p class="mb-4 text-sm">Updated at: <?php echo e($ip->updated_at); ?></p>
        <a href="<?php echo e(route('interesting_place.show', ['interesting_place' => $ip->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('interesting_place.edit', ['interesting_place' => $ip->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('interesting_place.destroy', ['interesting_place' => $ip->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div><?php /**PATH C:\Users\carke\Clases-FP\BalearTrek\baleartrek\resources\views/components/card-interesting-place.blade.php ENDPATH**/ ?>