<?PHP
namespace app\data;

class paper
{
    public function index()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        return ['state'=>true, 'msg'=>'当前方法为:' . __METHOD__, 'id'=> $id];
    }
}