<div class="form-group">
    <label for="title">Title</label>

    {!! Form::text('title', null, ['id' => 'title', 'name' => 'title', 'placeholder' => 'Enter a title', 'class' => 'form-control']); !!}
</div>

<div class="form-group">
    <label for="image">Image</label>

    <input type="file" class="form-control-file" id="image" name="image">
</div>

<div class="form-group">
    <label for="body">Body</label>

    {!! Form::textarea('body', null, ['id' => 'body', 'name' => 'body', 'class' => 'form-control']); !!}
</div>