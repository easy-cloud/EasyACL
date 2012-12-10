<?php
namespace ACL\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\RuntimeException;
/**
   * AbstractACLService
   *
   * @category   AbstractService
   * @package    ACL
   * @subpackage Service
   * @author     Alexander Janssen <a.janssen@easy-cloud.eu>
   * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
   * @version    1.0
   * @link       http://bitbucket.com/ajanssen/acl
*/
class AbstractACLService implements ServiceLocatorAwareInterface
{
    protected $options = array();

    protected $errors = array();

    protected $cache = null;

    protected $session = null;

    protected $servicelocator;

    protected $entitymanager = null;

    protected $repository = null;
    /**
       * Constructor
       *
       * @param array $options Options
       *
       * @return AbstractACLService
    */
    public function __construct(array $options=array())
    {
        if (!empty($options)) {
            $this->mergeOptions($options);
        }

        return $this;
    }
    /**
       * Merge options
       *
       * @param array $options Options
       *
       * @return AbstractACLService
    */
    protected function mergeOptions($options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }
    /**
       * Add errors
       *
       * @param mixed $errors errors
       *
       * @return AbstractACLService
    */
    public function addErrors($errors)
    {
        if (!is_array($errors)) {
            return $this->addError($errors);
        }

        foreach ($errors as $error) {
            $this->addError($error);
        }

        return $this;
    }
    /**
       * Add error
       *
       * @param mixed $error error
       *
       * @return AbstractACLService
    */
    public function addError($error)
    {
        $this->errors[] = $error;

        return $this;
    }
    /**
       * getLastError
       *
       * @return last error
    */
    public function getLastError()
    {
        return array_pop($this->errors);
    }
    /**
       * getErrors
       *
       * @return Errors
    */
    public function getErrors()
    {
        return $this->errors;
    }
    /**
       * SetErrors
       *
       * @param array $errors errors
       *
       * @return AbstractACLService
    */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }
    /**
       * getCache
       *
       * @return cache
    */
    public function getCache()
    {
        if ($this->cache === null) {
            $this->setCache();
        }

        return $this->cache;
    }
    /**
       * getRepository
       *
       * @return doctrine repository
    */
    public function getRepository()
    {
        if ($this->repository === null) {
            if (!isSet($this->options['model'])) {
                throw new RuntimeException('You\'ve not specified a valid model');
            } else {
                $this->setRepository($this->getEntityManager()->getRepository($this->options['model']));
            }
        }

        return $this->repository;
    }
    /**
       * setRepository
       *
       * @param \Doctrine\ORM\EntityRepository $repository repository
       *
       * @return AbstractACLService
    */
    public function setRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->repository = $repository;

        return $this;
    }
    /**
       * getEntityManager
       *
       * @return enitymanager
    */
    public function getEntityManager()
    {
        $this->servicelocator->get('doctrine.driver.orm_default')->getAllClassNames();
        if (null === $this->entitymanager) {
            $this->setEntityManager($this->servicelocator->get('doctrine.entitymanager.orm_default'));
        }

        return $this->entitymanager;
    }
    /**
       * setEntityManager
       *
       * @param \Doctrine\ORM\EntityManager $entitymanager entitymanager
       *
       * @return AbstractACLService
    */
    public function setEntityManager($entitymanager)
    {
        $this->entitymanager=$entitymanager;

        return $this;
    }

    /**
     * Set serviceManager instance
     *
     * @param ServiceLocatorInterface $servicelocator servicelocator
     *
     * @return AbstractACLService
     */
    public function setServiceLocator(ServiceLocatorInterface $servicelocator)
    {
        $this->servicelocator = $servicelocator;

        return $this;
    }

    /**
        * Set serviceManager instance
        *
        * @return serviceLocator
    */
    public function getServiceLocator()
    {
        return $this->servicelocator;
    }

}
