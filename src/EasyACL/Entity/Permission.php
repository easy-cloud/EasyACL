<?php
    namespace EasyACL\Entity;
    use Doctrine\ORM\Mapping as ORM,
        Zend\InputFilter\Factory as InputFactory,
        Zend\InputFilter\InputFilter,
        Zend\InputFilter\InputFilterAwareInterface,
        Zend\InputFilter\InputFilterInterface,
        Doctrine\ORM\PersistentCollection;

                                /* Under this line you can make your database! */

    /**
     * @ORM\Entity
     * @ORM\Table(name="`permission`")
     */
    class Permission
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer",unique=true);
         * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
         * @ORM\Column(type="string")
        */
        protected $namespace;

        /**
         * @ORM\Column(type="string")
        */
        protected $controller;

        /**
         * @ORM\Column(type="string")
        */
        protected $action;

                                /* Under this line you may edit functions, Don't worry you won't void the warranty i will guaranty you! */

                                /* Did you mess it up? Yes ok, you just voided the warranty. */

                                /* Don't remove functions under here!!!!!!!! */


                                /* Really don't! */

        /**
         * Magic getter to expose protected properties.
         *
         * @param string $property
         * @return mixed
        */

        public function __get($property)
        {
            return $this->$property;
        }

        /**
         * Magic setter to save protected properties.
         *
         * @param string $property
         * @param mixed $value
        */

        public function __set($property, $value)
        {
            if ($property==="password"&&$value!==$this->password) {
                $bcrypt = new Bcrypt();
                $bcrypt->setSalt(51292170314052011201451452855644564);
                $value=$bcrypt->create($value);
            }
            $this->$property = $value;
        }

                                /* I just told you don't edit under that line! SO GO AWAY FROM HERE! */

        public function exchangeArray($data=array())
        {
            if (!empty($data)) {
                foreach ($data as $key=>$value) {
                    $this->__set($key, $value);
                }
            }

            return $this;
        }

        public function getArrayCopy()
        {
            return get_object_vars($this);
        }

        public function setInputFilter(InputFilterInterface $inputFilter)
        {
            throw new \Exception("Not used");
        }

                                /* Voided warranty (probaly again you bad developer!), now you're screwed */
    }
