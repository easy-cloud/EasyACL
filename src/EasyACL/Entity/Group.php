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
     * @ORM\Table(name="`group`")
     */

    class Group
    {
        protected $inputFilter;

        /**
         * @ORM\Id
         * @ORM\Column(type="integer",unique=true);
         * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
         * @ORM\Column(type="string")
        */
        protected $name;

        /**
         * @ORM\ManyToMany(targetEntity="User", mappedBy="group", cascade={"persist", "detach"})
        */
        private $user;

        /**
         * @ORM\OneToOne(targetEntity="Roles", mappedBy="group_id", cascade={"persist", "detach"})
        */
        protected $roles;

                                /* Under this line you may edit functions, Don't worry you won't void the warranty i will guaranty you! */

        public function __construct()
        {
            $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        }

        public function getName()
        {
            return $this->name;
        }

        public function getInputFilter()
        {
            if (!$this->inputFilter) {
                $inputFilter = new InputFilter();

                $factory = new InputFactory();

                $inputFilter->add($factory->createInput(array(
                    'name'       => 'id',
                    'required'   => true,
                    'filters' => array(
                        array('name'    => 'Int'),
                    ),
                )));

                $inputFilter->add($factory->createInput(array(
                    'name'     => 'name',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                )));

                $this->inputFilter=$inputFilter;
            }

            return $this->inputFilter;
        }

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
