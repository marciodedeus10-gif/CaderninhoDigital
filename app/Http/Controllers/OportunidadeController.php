use App\Models\Oportunidade;
use App\Models\Cliente;
use Illuminate\Http\Request;

class OportunidadeController extends Controller
{

public function index()
{
    $oportunidades = Oportunidade::all();
    return view('oportunidades.index', compact('oportunidades'));
}

public function create()
{
    $clientes = Cliente::all();
    return view('oportunidades.create', compact('clientes'));
}

public function store(Request $request)
{
    Oportunidade::create($request->all());

    return redirect()->route('oportunidades.index');
}

public function edit($id)
{
    $oportunidade = Oportunidade::findOrFail($id);
    $clientes = Cliente::all();

    return view('oportunidades.edit', compact('oportunidade','clientes'));
}

public function update(Request $request, $id)
{
    $oportunidade = Oportunidade::findOrFail($id);
    $oportunidade->update($request->all());

    return redirect()->route('oportunidades.index');
}

public function destroy($id)
{
    $oportunidade = Oportunidade::findOrFail($id);
    $oportunidade->delete();

    return redirect()->route('oportunidades.index');
}

}
