<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight">Data Trobada: <?php echo e($meeting->day); ?></h5>
        <p class="mb-4 text-sm">Meeting ID: <?php echo e($meeting->id); ?></p>
        <p class="mb-4 text-sm">ID del guia: <?php echo e($meeting->user_id); ?></p>
        <p class="mb-4 text-sm">ID de la Excursió: <?php echo e($meeting->trek_id); ?></p>
        <p class="mb-4 text-sm">Hora de la trobada: <?php echo e($meeting->time); ?></p>
        <p class="mb-4 text-sm">Puntuació total: <?php echo e($meeting->totalScore); ?></p>
        <p class="mb-4 text-sm">Total de puntuats: <?php echo e($meeting->countScore); ?></p>
        <p class="mb-4 text-sm">Data de inici: <?php echo e($meeting->appDateIni); ?></p>
        <p class="mb-4 text-sm">Data de finalització: <?php echo e($meeting->appDateEnd); ?></p>
        <p class="mb-4 text-sm">Created at: <?php echo e($meeting->created_at); ?></p>
        <p class="mb-4 text-sm">Updated at: <?php echo e($meeting->updated_at); ?></p>
        <a href="<?php echo e(route('meetingCRUD.show', ['meetingCRUD' => $meeting->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="<?php echo e(route('meetingCRUD.edit', ['meetingCRUD' => $meeting->id])); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="<?php echo e(route('meetingCRUD.destroy', ['meetingCRUD' => $meeting->id])); ?>" method="POST" class="float-right">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div><?php /**PATH C:\Users\carke\Clases-FP\BalearTrek\baleartrek\resources\views/components/card-meeting.blade.php ENDPATH**/ ?>