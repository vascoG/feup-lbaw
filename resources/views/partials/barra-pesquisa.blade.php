<form method="GET" action="{{ $acaoPesquisa }}">
    <div class="input-group">
        <input class="form-control" name="query" placeholder="{{ $placeholder }}"></input>
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>