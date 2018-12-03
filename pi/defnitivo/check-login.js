async function checkar() { // verifica o login
    let requisicao = await fetch(`../consulta/login-check.php`)
    let resposta = await requisicao.json();
    if (!resposta) {
		location.href = "indexNew.html"
    }
}
checkar()