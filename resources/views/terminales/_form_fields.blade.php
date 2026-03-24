{{-- resources/views/terminales/_form_fields.blade.php --}}
<div class="mb-3">
    <label for="{{ $prefix }}_nombre" class="form-label">Nombre de la Terminal</label>
    <input type="text" name="nombre" id="{{ $prefix }}_nombre" value="{{ old('nombre', $terminal?->nombre) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label for="{{ $prefix }}_direccion" class="form-label">Dirección</label>
    <input type="text" name="direccion" id="{{ $prefix }}_direccion" value="{{ old('direccion', $terminal?->direccion) }}" class="form-control" required>
</div>
