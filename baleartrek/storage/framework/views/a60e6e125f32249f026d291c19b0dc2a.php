<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <!-- Para prevenir errores  -->
        <?php $user = $user ?? null; ?>
        <h5 class="mb-2 text-xl font-medium leading-tight"><?php echo e($user->id); ?></h5>
        <p class="mb-4 text-base">Nom: <?php echo e($user->name); ?></p>
        <p class="mb-4 text-base">Cognom: <?php echo e($user->lastname); ?></p>
        <p class="mb-4 text-base">DNI: <?php echo e($user->dni); ?></p>
        <p class="mb-4 text-base">Email: <?php echo e($user->email); ?></p>
        <p class="mb-4 text-base">Email Verified At: <?php echo e($user->email_verified_at); ?></p>
        <p class="mb-4 text-base">Telèfon: <?php echo e($user->phone); ?></p>
        <p class="mb-4 text-base">Estat: <?php echo e($user->status); ?></p>
        <p class="mb-4 text-base">Id del rol: <?php echo e($user->role_id); ?></p>
        <p class="mb-4 text-sm">Created at: <?php echo e($user->created_at); ?></p>
        <p class="mb-4 text-sm">Updated at: <?php echo e($user->updated_at); ?></p>
        <a href="<?php echo e(route('userCRUD.show', ['userCRUD' => $user->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('userCRUD.edit', ['userCRUD' => $user->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('userCRUD.destroy', ['userCRUD' => $user->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div><?php /**PATH C:\Users\carke\Clases-FP\BalearTrek\baleartrek\resources\views/components/card-user.blade.php ENDPATH**/ ?>