use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;
use Cake\Log\Log;
use Cake\Routing\Router;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

    use ModelAwareTrait;

    public $Orders;
    public $Products;

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();


        // Load the Orders model
        $this->Orders = $this->fetchModel('Orders');

        // Load the Products model
        $this->Products = $this->fetchModel('Products');

        $this->Authentication->allowUnauthenticated(['initializeHostedPaymentPage', 'return']);
    }
}
