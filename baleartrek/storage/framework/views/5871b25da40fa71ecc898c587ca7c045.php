<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight"><?php echo e($trek->name); ?></h5>
        <h3 class="mb-2 text-xl font-medium leading-tight">Trek ID: <?php echo e($trek->id); ?></h3>
        <h3 class="mb-2 text-xl font-medium leading-tight">Reg. Number: <?php echo e($trek->regNumber); ?></h3>
        <p class="mb-4 text-base">Estat: <?php echo e($trek->status); ?></p>
        <p class="mb-4 text-sm">Posted: <?php echo e($trek->municipality_id); ?></p>
        <p class="mb-4 text-sm">Created at: <?php echo e($trek->created_at); ?></p>
        <p class="mb-4 text-sm">Updated at: <?php echo e($trek->updated_at); ?></p>
        
        <?php if($trek->meetings->count() > 0): ?>
            <div class="mb-4">
                <h4 class="font-semibold text-lg mb-2">Reuniones Asociadas:</h4>
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = $trek->meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($meeting->day ?? ' '); ?> (ID: <?php echo e($meeting->id); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="mb-4 text-sm text-gray-500">No hay reuniones asociadas</p>
        <?php endif; ?>
        
        <?php if($trek->interestingPlaces->count() > 0): ?>
            <div class="mb-4">
                <h4 class="font-semibold text-lg mb-2">Lugares Interesantes Asociados:</h4>
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = $trek->interestingPlaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($place->name ?? 'Sin nombre'); ?> (ID: <?php echo e($place->id); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="mb-4 text-sm text-gray-500">No hay lugares interesantes asociados</p>
        <?php endif; ?>
        
        <a href="<?php echo e(route('trekCRUD.show', ['trekCRUD' => $trek->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('trekCRUD.edit', ['trekCRUD' => $trek->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('trekCRUD.destroy', ['trekCRUD' => $trek->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div><?php /**PATH C:\Users\carke\Clases-FP\BalearTrek\baleartrek\resources\views/components/card-trek.blade.php ENDPATH**/ ?>