<form method="post" action="/meetings/create">
  @csrf
  <div class="row">
    <div class="col-12">
      <input class="form-control" type="text" name="topic" placeholder="議題">
    </div>
    <div class="col-12">
      <input class="form-control" type="text" name="agenda" placeholder="概要">
    </div>
    <div class="col-12">
      <input type="submit" class="btn btn-primary">
    </div>
  </div>
</form>