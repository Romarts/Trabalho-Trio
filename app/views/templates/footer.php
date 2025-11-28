</div> 

<style>
    /* --- RODAPÉ RÚSTICO --- */
    .footer-custom {
        background-color: #2c2a29; /* Cinza Café */
        color: #d3d3d3;
        border-top: 4px solid #A0522D; /* Marrom */
        font-size: 0.9rem;
    }

    .footer-title {
        color: #fff;
        font-family: 'Georgia', serif;
        font-weight: bold;
        margin-bottom: 1.2rem;
        border-bottom: 1px solid #444;
        display: inline-block;
        padding-bottom: 5px;
    }

    .footer-link {
        color: #bbb;
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 0.6rem;
    }

    .footer-link:hover {
        color: #A0522D; /* Marrom ao passar o mouse */
        transform: translateX(5px);
    }

    .social-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #444;
        color: white;
        border-radius: 50%;
        margin-right: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        background-color: #A0522D;
        color: white;
    }
</style>

<footer class="footer-custom pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-title">Arte & Madeira</h5>
                <p>
                    Transformando natureza em decoração. Peças exclusivas para deixar seu ambiente mais aconchegante.
                </p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-title">Navegação</h5>
                <ul class="list-unstyled">
                    <li><a href="?page=home" class="footer-link">Início</a></li>
                    <li><a href="?page=produtos" class="footer-link">Nossa Coleção</a></li>
                    <li><a href="?page=carrinho" class="footer-link">Carrinho</a></li>
                    <li><a href="?page=login" class="footer-link">Minha Conta</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5 class="footer-title">Contato</h5>
                <p class="mb-2"><i class="bi bi-envelope me-2"></i> contato@artemadeira.com</p>
                <p><i class="bi bi-whatsapp me-2"></i> (11) 99999-9999</p>
                
                <div class="mt-3">
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                </div>
            </div>
        </div>

        <hr style="border-color: #555;">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                © 2024 <strong>Arte & Madeira</strong>.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <small class="text-muted">Feito à mão.</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>