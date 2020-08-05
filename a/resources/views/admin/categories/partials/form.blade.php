<label for="">Статус</label>
<select class="form-control" name="published">
    @if (isset($category->id))
        <option value="0" @if ($category->published == 0) selected="" @endif>Не опубликовано</option>
        <option value="1" @if ($category->published == 1) selected="" @endif>Опубликовано</option>
    @else
        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>
    @endif
</select>

<label for="">ФИО</label>
<input type="text" class="form-control" name="title"  required>



<label for="">Slug</label>
<input class="form-control" type="text" name="slug" placeholder="Автоматическая генерация"  readonly="">



<hr />

<input class="btn btn-primary" type="submit" value="Сохранить">
