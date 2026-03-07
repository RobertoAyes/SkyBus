<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroTerminal;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class RegistroTeminalController extends Controller
{
    private $departamentosHonduras = [
        'Atlántida', 'Colón', 'Comayagua', 'Copán', 'Cortés', 'Choluteca',
        'El Paraíso', 'Francisco Morazán', 'Gracias a Dios', 'Intibucá',
        'Islas de la Bahía', 'La Paz', 'Lempira', 'Ocotepeque', 'Olancho',
        'Santa Bárbara', 'Valle', 'Yoro'
    ];

    private $municipiosHonduras = [
        'Atlántida' => ['La Ceiba', 'El Porvenir', 'Esparta', 'Jutiapa', 'La Másica', 'San Francisco', 'Tela', 'Arizona'],
        'Colón' => ['Trujillo', 'Balfate', 'Iriona', 'Limón', 'Sabá', 'Santa Fe', 'Santa Rosa de Aguán', 'Sonaguera', 'Tocoa', 'Bonito Oriental'],
        'Comayagua' => ['Comayagua', 'Ajuterique', 'El Porvenir', 'Esquías', 'Humuya', 'La Libertad', 'Lamaní', 'La Paz', 'Las Lajas', 'Lejamaní', 'Meámbar', 'Minas de Oro', 'Ojo de Agua', 'San Jerónimo', 'San José de Comayagua', 'San José del Potrero', 'San Luis', 'San Sebastián', 'Siguatepeque', 'Taulabé', 'Villa de San Antonio'],
        'Copán' => ['Santa Rosa de Copán', 'Cabañas', 'Concepción', 'Copán Ruinas', 'Corquín', 'Dolores', 'Dulce Nombre', 'El Paraíso', 'Florida', 'La Jigua', 'La Unión', 'Lucerna', 'Mercedes', 'San Agustín', 'San Fernando', 'San Francisco del Valle', 'San Jerónimo', 'San José', 'San Juan de Opoa', 'San Nicolás', 'San Pedro de Copán', 'Santa Rita', 'Trinidad de Copán', 'Veracruz'],
        'Cortés' => ['San Pedro Sula', 'Choloma', 'La Lima', 'Omoa', 'Pimienta', 'Potrerillos', 'Puerto Cortés', 'San Antonio de Cortés', 'San Manuel', 'Santa Cruz de Yojoa', 'Villanueva'],
        'Choluteca' => ['Choluteca', 'Apacilagua', 'Concepción de María', 'Corpus', 'Duyure', 'El Triunfo', 'Marcovia', 'Morolica', 'Namasigüe', 'Orocuina', 'Pespire', 'San Antonio de Flores', 'San Isidro', 'San José', 'San Marcos de Colón', 'Santa Ana de Yusguare'],
        'El Paraíso' => ['Yuscarán', 'Alauca', 'Danlí', 'El Paraíso', 'Güinope', 'Jacaleapa', 'Liure', 'Morocelí', 'Oropolí', 'Potrerillos', 'San Antonio de Flores', 'San Lucas', 'San Matías', 'Soledad', 'Teupasenti', 'Texiguat', 'Trojes', 'Vado Ancho', 'Yauyupe'],
        'Francisco Morazán' => ['Distrito Central (Tegucigalpa y Comayagüela)', 'Alubarén', 'Cedros', 'Curarén', 'El Porvenir', 'Guaimaca', 'La Libertad', 'La Venta', 'Lepaterique', 'Maraita', 'Marale', 'Nueva Armenia', 'Ojojona', 'Orica', 'Reitoca', 'Sabana Grande', 'San Antonio de Oriente', 'San Buenaventura', 'San Ignacio', 'San Juan de Flores (Cantarranas)', 'San Miguelito', 'Santa Ana', 'Santa Lucía', 'Talanga', 'Tatumbla', 'Valle de Ángeles', 'Vallecillo', 'Villa de San Francisco'],
        'Gracias a Dios' => ['Puerto Lempira', 'Ahuas', 'Brus Laguna', 'Juan Francisco Bulnes', 'Ramón Villeda Morales', 'Wampusirpi'],
        'Intibucá' => ['La Esperanza', 'Camasca', 'Colomoncagua', 'Concepción', 'Dolores', 'Intibucá', 'Jesús de Otoro', 'Magdalena', 'Masaguara', 'San Antonio', 'San Francisco de Opalaca', 'San Isidro', 'San Juan', 'San Marco de la Sierra', 'San Miguelito', 'Santa Lucía', 'Yamaranguila'],
        'Islas de la Bahía' => ['Roatán', 'Guanaja', 'José Santos Guardiola', 'Útila'],
        'La Paz' => ['La Paz', 'Aguanqueterique', 'Cabañas', 'Cane', 'Chinacla', 'Guajiquiro', 'Lauterique', 'Marcala', 'Mercedes de Oriente', 'Opatoro', 'San Antonio del Norte', 'San José', 'San Juan', 'San Pedro de Tutule', 'Santa Ana', 'Santa Elena', 'Santa María', 'Santiago de Puringla', 'Yarula'],
        'Lempira' => ['Gracias', 'Belén', 'Candelaria', 'Cololaca', 'Erandique', 'Gualcince', 'Guarita', 'La Campa', 'La Iguala', 'Las Flores', 'La Unión', 'La Virtud', 'Lepaera', 'Mapulaca', 'Piraera', 'San Andrés', 'San Francisco', 'San Juan Guarita', 'San Manuel Colohete', 'San Marcos de Caiquín', 'San Rafael', 'San Sebastián', 'Santa Cruz', 'Talgua', 'Tambla', 'Tomalá', 'Valladolid', 'Virginia'],
        'Ocotepeque' => ['Nueva Ocotepeque', 'Belén Gualcho', 'Concepción', 'Dolores Merendón', 'Fraternidad', 'La Encarnación', 'La Labor', 'Lucerna', 'Mercedes', 'San Fernando', 'San Francisco del Valle', 'San Jorge', 'San Marcos', 'Santa Fe', 'Sensenti', 'Sinuapa'],
        'Olancho' => ['Juticalpa', 'Campamento', 'Catacamas', 'Concordia', 'Dulce Nombre de Culmí', 'El Rosario', 'Esquipulas del Norte', 'Gualaco', 'Guarizama', 'Guata', 'Guayape', 'Jano', 'La Unión', 'Mangulile', 'Manto', 'Potrerillos', 'Salamá', 'San Esteban', 'San Francisco de Becerra', 'San Francisco de la Paz', 'Santa María del Real', 'Silca', 'Yocón'],
        'Santa Bárbara' => ['Santa Bárbara', 'Arada', 'Atima', 'Azacualpa', 'Ceguaca', 'Chinda', 'Concepción del Norte', 'Concepción del Sur', 'El Níspero', 'Gualala', 'Ilama', 'Las Vegas', 'Macuelizo', 'Naranjito', 'Nueva Frontera', 'Nuevo Celilac', 'Petoa', 'Protección', 'Quimistán', 'San Francisco de Ojuera', 'San Luis', 'San Marcos', 'San Nicolás', 'San Pedro Zacapa', 'San Vicente Centenario', 'Santa Rita', 'Trinidad', 'Tencoa'],
        'Valle' => ['Nacaome', 'Alianza', 'Amapala', 'Aramecina', 'Caridad', 'Goascorán', 'Langue', 'San Francisco de Coray', 'San Lorenzo'],
        'Yoro' => ['Yoro', 'Arenal', 'El Negrito', 'El Progreso', 'Jocón', 'Morazán', 'Olanchito', 'Santa Rita', 'Sulaco', 'Victoria', 'Yorito']
    ];

    public function index(Request $request)
    {
        $query = RegistroTerminal::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('contacto')) {
            $query->where(function ($q) use ($request) {
                $q->where('telefono', 'like', '%' . $request->contacto . '%')
                    ->orWhere('correo', 'like', '%' . $request->contacto . '%');
            });
        }

        if ($request->filled('ubicacion')) {
            $query->where(function ($q) use ($request) {
                $q->where('departamento', 'like', '%' . $request->ubicacion . '%')
                    ->orWhere('municipio', 'like', '%' . $request->ubicacion . '%')
                    ->orWhere('direccion', 'like', '%' . $request->ubicacion . '%');
            });
        }

        $terminales = $query->paginate(5);

        return view('terminales.index', compact('terminales'))
            ->with('nombre', $request->nombre)
            ->with('contacto', $request->contacto)
            ->with('ubicacion', $request->ubicacion);
    }

    public function create()
    {
        $departamentos = $this->departamentosHonduras;
        $municipiosHonduras = $this->municipiosHonduras;
        return view('terminales.create', compact('departamentos', 'municipiosHonduras'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|regex:/^\S.*$/',
            'codigo' => 'required|string|max:10|unique:registro_terminal,codigo|regex:/^\S.*$/',
            'direccion' => 'required|string|max:150|regex:/^\S.*$/',
            'departamento' => [
                'required',
                'string',
                Rule::in($this->departamentosHonduras),
            ],
            'municipio' => 'required|string|max:50|regex:/^\S.*$/',
            'telefono' => 'required|string|max:8|regex:/^[983]\d{7}$/|unique:registro_terminal,telefono',
            'correo' => 'required|email:rfc,dns|max:50|unique:registro_terminal,correo|regex:/^\S.*$/',
            'horario_apertura' => 'required|date_format:H:i',
            'horario_cierre' => 'required|date_format:H:i|after:horario_apertura',
            'descripcion' => 'required|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
        ]);

        try {
            // ✅ SOLO CREAR EN registro_terminal
            RegistroTerminal::create($validatedData);

            return redirect()->route('terminales.index')->with('success', 'Terminal creada correctamente.');

        } catch (\Exception $e) {
            Log::error('Error FATAL al crear la terminal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error del sistema al guardar: ' . $e->getMessage());
        }
    }

    public function show(RegistroTerminal $terminal)
    {
        return view('terminales.show', compact('terminal'));
    }

    public function edit(RegistroTerminal $terminal)
    {
        $departamentos = $this->departamentosHonduras;
        $municipiosHonduras = $this->municipiosHonduras;

        return view('terminales.edit', compact('terminal', 'departamentos', 'municipiosHonduras'));
    }

    public function update(Request $request, RegistroTerminal $terminal)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:100|regex:/^\S.*$/',
                'codigo' => 'required|string|max:10|unique:registro_terminal,codigo,' . $terminal->id . '|regex:/^\S.*$/',
                'direccion' => 'required|string|max:150|regex:/^\S.*$/',
                'departamento' => [
                    'required',
                    'string',
                    Rule::in($this->departamentosHonduras),
                ],
                'municipio' => 'required|string|max:50|regex:/^\S.*$/',
                'telefono' => 'required|string|max:8|regex:/^[983]\d{7}$/|unique:registro_terminal,telefono,' . $terminal->id,
                'correo' => 'required|email:rfc,dns|max:50|unique:registro_terminal,correo,' . $terminal->id . '|regex:/^\S.*$/',
                'horario_apertura' => 'required|date_format:H:i',
                'horario_cierre' => 'required|date_format:H:i|after:horario_apertura',
                'descripcion' => 'required|string',
                'latitud' => 'nullable|numeric|between:-90,90',
                'longitud' => 'nullable|numeric|between:-180,180',
            ]);

            // ✅ SOLO ACTUALIZAR EN registro_terminal
            $terminal->update($validatedData);

            return redirect()->route('terminales.index')->with('success', 'Terminal actualizada correctamente.');

        } catch (\Exception $e) {
            Log::error('Error FATAL al actualizar la terminal: ' . $e->getMessage());
            return back()->with('error', 'Error crítico del sistema: ' . $e->getMessage())->withInput();
        }
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'registro_terminal_id');
    }

    public function destroy()
    {
        // Lógica de eliminación...
    }
}
