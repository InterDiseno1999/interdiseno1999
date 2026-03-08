<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Sistema - InterDiseño</title>
    <link rel="stylesheet" href="{{asset('img/logo_interdiseno_nav.png')  }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #C0B7B1;
        }
        .bg-admin-dark { background-color: #3a3b3d; }
    </style>
</head>
<body class="h-screen flex items-center justify-center px-4">

    <!-- Card de Acceso Camuflado -->
    <div class="bg-white/80 backdrop-blur-md p-10 rounded-3xl shadow-2xl border border-white/20 max-w-sm w-full transform hover:scale-[1.01] transition-all duration-500">
        
        <!-- Cabecera Discreta -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-gray-500 text-xs font-semibold uppercase tracking-[0.2em] mb-1">Área Restringida</h1>
            <p class="text-gray-400 text-[10px]">InterDiseño | Gestión Interna</p>
        </div>

        <!-- Formulario Secreto -->
        <form action="{{ route('admin.auth') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <input type="password" name="password" required autofocus
                    placeholder="Introducir código de acceso" 
                    class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#C0B7B1] focus:border-transparent outline-none text-center text-sm transition-all placeholder:text-gray-300">
            </div>

            <button type="submit" 
                class="w-full py-4 bg-admin-dark text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-black hover:shadow-lg transition-all active:scale-95">
                Validar Identidad
            </button>
        </form>

        <!-- Mensaje de Error -->
        @if(session('error'))
            <p class="mt-4 text-center text-[10px] text-red-400 font-medium">Credenciales no válidas</p>
        @endif

        <div class="mt-8 text-center">
            <a href="/" class="text-[9px] text-gray-400 hover:text-gray-600 transition uppercase tracking-tighter">Volver al sitio público</a>
        </div>
    </div>

</body>
</html>