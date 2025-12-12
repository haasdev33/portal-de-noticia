<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Contato</h5>
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf
            <div class="mb-2">
                <input type="text" name="name" class="form-control" placeholder="Nome" required>
            </div>
            <div class="mb-2">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-2">
                <input type="text" name="phone" class="form-control" placeholder="Telefone (opcional)">
            </div>
            <div class="mb-2">
                <input type="text" name="subject" class="form-control" placeholder="Assunto" required>
            </div>
            <div class="mb-2">
                <textarea name="message" class="form-control" rows="4" placeholder="Mensagem" required></textarea>
            </div>
            <div style="display:none;" aria-hidden="true"><input type="text" name="hp" value=""></div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">Enviar</button>
                <button class="btn btn-outline-secondary" type="reset">Limpar</button>
            </div>
        </form>
    </div>
</div>
