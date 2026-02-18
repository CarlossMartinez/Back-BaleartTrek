<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      <?php echo e(__('Gestión de Usuarios')); ?>

    </h2>
   <?php $__env->endSlot(); ?>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

        <?php if(session('status')): ?>
          <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded">
            <?php echo e(session('status')); ?>

          </div>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Lista de Usuarios</h3>
          <a href="<?php echo e(route('userCRUD.create')); ?>"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
            + Nuevo Usuario
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full border-collapse border border-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">ID
                </th>
                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                  Nombre</th>
                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                  Email</th>
                <th class="border border-gray-200 px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Rol
                </th>
                <th class="border border-gray-200 px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase">
                  Acciones</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($user->id); ?></td>
                  <td class="px-4 py-3 text-sm font-medium text-gray-900"><?php echo e($user->name); ?></td>
                  <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($user->email); ?></td>
                  <td class="px-4 py-3 text-sm">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($user->role->name == 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                      <?php echo e($user->role->name ?? 'Sin Rol'); ?>

                    </span>
                  </td>
                  <td class="px-4 py-3 text-sm text-center">
                    <div class="flex justify-center space-x-3">

                      <a href="<?php echo e(route('userCRUD.show', $user->id)); ?>" class="text-indigo-600 hover:text-indigo-900"
                        title="View File" data-toggle="tooltip"><span class="fa fa-eye"></span></a>

                      <a href="<?php echo e(route('userCRUD.edit', $user->id)); ?>" class="text-yellow-600 hover:text-yellow-900"
                        title="Update File" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>

                      <form action="<?php echo e(route('userCRUD.destroy', $user->id)); ?>" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          <?php echo e($users->links()); ?>

        </div>
      </div>
    </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

<a href="customersRead.php?id='   . $row->customer_id . '" class="mr-2" title="View File" data-toggle="tooltip"><span
    class="fa fa-eye"></span></a>' .
'<a href="customersUpdate.php?id=' . $row->customer_id . '" class="mr-2" title="Update File" data-toggle="tooltip"><span
    class="fa fa-pencil"></span></a>' .
'<a href="customersDelete.php?id=' . $row->customer_id . '" class="mr-2" title="Delete File" data-toggle="tooltip"><span
    class="fa fa-trash"></span></a>' .<?php /**PATH C:\Users\Eduar\2N-DAW\DWES\BalearTrek\baleartrek\resources\views/userCRUD/index.blade.php ENDPATH**/ ?>