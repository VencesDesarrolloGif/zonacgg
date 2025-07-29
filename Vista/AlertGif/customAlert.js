const AlertGif = (() => {
  function init() {
    if (document.getElementById('miAlert')) return; // Ya está cargado

    // CSS como string (corregido para evitar conflictos)
    const estilos = `
      .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        transition: opacity 0.3s ease;
        pointer-events: all;
      }
      .oculto {
        opacity: 0;
        pointer-events: none;
      }
      .alert-Gif {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        background-color: white;
        border: 2px solid #ccc;
        padding: 50px;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
        border-radius: 100px;
        z-index: 1000;
        opacity: 1;
        transition: all 0.3s ease;
      }
      .alert-Gif.oculto {
        opacity: 0;
        pointer-events: none;
        transform: translate(-50%, -20%);
      }
      .icono-alerta {
        font-size: 40px;
        margin-bottom: 10px;
      }
      .contenido-alerta {
        display: flex;
        align-items: center;
        gap: 20px;
      }
      .alerta-img-estatica {
        width: 180px;
        height: 180px;
        object-fit: contain;
      }
      .mensaje-contenido {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
    `;

    // Agregar estilos al head
    const style = document.createElement('style');
    style.textContent = estilos;
    document.head.appendChild(style);

    // HTML de la alerta personalizada
    const html = `
      <div id="overlay" class="overlay oculto"></div>
      <div id="miAlert" class="alert-Gif oculto">
        <div class="contenido-alerta">
          <img src="img/MaraVilla1.png" alt="Decoración" class="alerta-img-estatica">
          <div class="mensaje-contenido">
            <div id="iconoAlerta" class="icono-alerta">⚠️</div><br>
            <h3 id="mensajeAlerta"></h3><br>
            <button onclick="AlertGif.cerrar()" class="boton azulTransparente">Cerrar</button>
          </div>
        </div>
      </div>
    `;
    const div = document.createElement('div');
    div.innerHTML = html;
    document.body.appendChild(div);
  }

  function mostrar(mensaje, tipo = 'info') {
    init();
    const alertBox = document.getElementById('miAlert');
    const overlay = document.getElementById('overlay');
    const mensajeTexto = document.getElementById('mensajeAlerta');
    const icono = document.getElementById('iconoAlerta');

    mensajeTexto.innerHTML = mensaje;

    switch (tipo) {
      case 'exito':
        icono.textContent = '✅';
        break;
      case 'error':
        icono.textContent = '❌';
        break;
      case 'advertencia':
        icono.textContent = '⚠️';
        break;
      default:
        icono.textContent = 'ℹ️';
    }

    alertBox.classList.remove('oculto');
    overlay.classList.remove('oculto');
  }

  function cerrar() {
    document.getElementById('miAlert')?.classList.add('oculto');
    document.getElementById('overlay')?.classList.add('oculto');
  }

  return { mostrar, cerrar };
})();
