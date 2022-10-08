@props(['name', 'options', 'checked' => false])

@foreach ($options as $value => $text)
    <div class="form-check">
        <input type="radio" name="{{ $name }}" value="{{ $value }}" @checked(old($name, $checked) == $value)
            {{ $attributes->class(['form-ckeck-input', 'is-invalid' => $errors->has($name)]) }} />
        <label class="form-ckeck-label">{{ $text }}</label>
    </div>
@endforeach
