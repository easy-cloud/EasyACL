<?php
namespace ACL\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\RuntimeException;
class AbstractACLService implements ServiceLocatorAwareInterface
{
	protected $_options = array();
    
    protected $_errors = array();
    
    protected $_cache = null;
    
    protected $_session = null;
    
    protected $_form = null;
    
    protected $_model = null;
    
    protected $servicelocator;

    protected $_entitymanager = null;

    protected $_repository = null;

    public function __construct(array $options=array())
    {
        if (!empty($options)) {
            $this->_mergeOptions($options);
        }
        return $this;
    }

    protected function _mergeOptions($options)
    {
        $this->_options = array_merge($this->_options, $options);
    }
    
    public function addErrors($errors)
    {
        if (!is_array($errors)) {
            return $this->addError($errors);
        }
        
        foreach ($errors as $index => $error) {
            $this->_errors[$index] = $error;
        }
        return $this;
    }
    
    public function addError($error)
    {
        $this->_errors[] = $error;
        return $this;
    }
    
    public function getLastError()
    {
        return array_pop($this->_errors);
    }
    
    public function getErrors()
    {
        return $this->_errors;
    }
    
    public function setErrors(array $errors)
    {
        $this->_errors = $errors;
        return $this;
    }
    
    public function getCache()
    {
        if ($this->_cache === null) {
            $this->setCache();
        }
        return $this->_cache;
    }

     public function getSession()
    {
        if ($this->_session === null) {
            $this->setSession('service');
        }
        return $this->_session;
    }

    public function setSession($name)
    {
        // $this->_session = new Zend\Sessions($name);
        return $this;
    }
    
    public function getRepository()
    {
        if ($this->_repository === null) {
            if (!isSet($this->_options['model'])) {
                throw new RuntimeException('You\'ve not specified a valid model');
            } else {
                $this->setRepository($this->getEntityManager()->getRepository($this->_options['model']));
            }
        }
        return $this->_repository;
    }
    
    public function setRepository(\Doctrine\ORM\EntityRepository $repository)
    {
        $this->_repository = $repository;
        return $this;
    }

    public function getEntityManager()
    {
    	$this->servicelocator->get('doctrine.driver.orm_default')->getAllClassNames();
        if (null === $this->_entitymanager) {
            $this->setEntityManager($this->servicelocator->get('doctrine.entitymanager.orm_default'));
        }
        return $this->_entitymanager;
    }

    public function setEntityManager($entitymanager){
    	$this->_entitymanager=$entitymanager;
    	return $this;
    }

    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $servicelocator)
    {
        $this->servicelocator = $servicelocator;
        return $this;
    }

    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function getServiceLocator()
    {
        return $this->servicelocator;
    }

}