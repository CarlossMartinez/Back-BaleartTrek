<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <?php $municipality = $municipality ?? null; ?>

        <h5 class="mb-2 text-xl font-medium leading-tight"><?php echo e($municipality->name); ?></h5>
        <h3 class="mb-2 text-xl font-medium leading-tight">ID del municipi: <?php echo e($municipality->id); ?></h3> 
        <h3 class="mb-2 text-xl font-medium leading-tight">Id de la illa: <?php echo e($municipality->island_id); ?></h3>               
        <h3 class="mb-2 text-xl font-medium leading-tight">Id de la zona: <?php echo e($municipality->zone_id); ?></h3>
        <p class="mb-4 text-sm">Created at: <?php echo e($municipality->created_at); ?></p>
        <p class="mb-4 text-sm">Updated at: <?php echo e($municipality->updated_at); ?></p>
        <a href="<?php echo e(route('municipalityCRUD.show', ['municipalityCRUD' => $municipality->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('municipalityCRUD.edit', ['municipalityCRUD' => $municipality->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('municipalityCRUD.destroy', ['municipalityCRUD' => $municipality->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div><?php /**PATH /var/www/html/resources/views/components/card-municipality.blade.php ENDPATH**/ ?>