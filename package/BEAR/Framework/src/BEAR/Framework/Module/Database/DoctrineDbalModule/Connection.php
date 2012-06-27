<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Database\DoctrineDbalModule;

use BEAR\Framework\Module\Database\DoctrineDbalModule\Pagerfanta\DoctrineDbalAdapter;

use Doctrine\DBAL\Connection as DbalConnection;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use BEAR\Framework\Module\Database\Pager;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrapView;

/**
 * Pager enabled connection
 *
 * @package    BEAR.Framework
 * @subpackage Database
 */
class Connection extends DbalConnection implements DriverConnection
{
    private $maxPerPage = 10;
    private $pageKey = '_start';
    private $pager = [];
    private $currentPage;
    private $viewOptions = [
        'prev_message' => '&laquo;',
        'next_message' => '&raquo;'
    ];
    private $view;
    private $routeGenerator;
    private $pagerfanta;

    public function setMaxPerPage($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;

        return $this;
    }

    public function setPageKey($pageKey)
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function setView(ViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    public function setRouteGenerator(Callable $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;

        return $this;
    }

    public function setViewOption($key, $value)
    {
        $this->viewOptions[$key] = $value;
    }

    /**
     * (non-PHPdoc)
     * @see Doctrine\DBAL.Connection::query()
     */
    public function query()
    {
        $this->currentPage = $this->currentPage ?: (isset($_GET[$this->pageKey]) ? $_GET[$this->pageKey] : 1);
        $firstResult = ($this->currentPage - 1) * $this->maxPerPage;
        $args = func_get_args();
        $query = $args[0];
        $this->pagerfanta = new Pagerfanta(new DoctrineDbalAdapter($this, $query));
        $this->pagerfanta->setMaxPerPage($this->maxPerPage)->setCurrentPage($this->currentPage, false, true);
        $pagerQuery = $this->getDatabasePlatform()->modifyLimitQuery($query, $this->maxPerPage, $firstResult);
        $args[0] = $pagerQuery;
        $result = call_user_func_array(array('Doctrine\DBAL\Connection', 'query'), $args);

        return $result;
    }

    public function getPager()
    {
        //view
        if (! $this->pagerfanta) {
            return [];
        }
        $pager = [
            'maxPerPage' => $this->maxPerPage,
            'current' => $this->currentPage,
            'total' => $this->pagerfanta->getNbResults(),
            'hasNext' => $this->pagerfanta->hasNextPage(),
            'hasPrevious' => $this->pagerfanta->hasPreviousPage(),
            'html' => $this->getHtml($this->pagerfanta)
        ];

        return $pager;
    }

    private function getHtml()
    {
        $view = $this->view ?: new TwitterBootstrapView;
        $routeGenerator = $this->routeGenerator ?: function($page) {
            return "?{$this->pageKey}={$page}";
        };
        $html = $view->render(
            $this->pagerfanta,
            $routeGenerator,
            $this->viewOptions
        );

        return $html;
    }
}
