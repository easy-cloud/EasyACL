<?php
    namespace EasyACL\Entity;
    use Doctrine\ORM\Mapping as ORM,
        Zend\InputFilter\Factory as InputFactory,
        Zend\InputFilter\InputFilter,
        Zend\InputFilter\InputFilterAwareInterface,
        Zend\InputFilter\InputFilterInterface,
        Doctrine\ORM\PersistentCollection,
        Zend\Crypt\Password\Bcrypt;

                                /* Under this line you can make your database! */
    /**
     * @ORM\Entity
     * @ORM\Table(name="user")
    */

    class User
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
         * @ORM\Column(type="string")
        */
        protected $surname;

        /**
         * @ORM\Column(type="string")
        */
        protected $email;

        /**
         * @ORM\Column(type="text")
        */
        protected $password;

        /**
         * @ORM\OneToOne(targetEntity="Roles", mappedBy="user_id")
        */
        protected $roles;

        /**
         * @ORM\ManyToMany(targetEntity="Group", inversedBy="user")
         * @ORM\JoinTable(name="user_group",
         *      joinColumns={@ORM\JoinColumn(name="User_id", referencedColumnName="id")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="Group_id", referencedColumnName="id")}
         *      )
        */
        private $group;

                                /* Under this line you may edit functions, Don't worry you won't void the warranty i will guaranty you! */

        public function __construct()
        {
            $this->group = new \Doctrine\Common\Collections\ArrayCollection();
        }

        public function getName()
        {
            return $this->email;
        }

        public function addGroup(\EasyACL\Entity\Group $group)
        {
            if (!$this->group->contains($group)) {
                $this->group->add($group);
            }
        }

        public function removeGroup(\EasyACL\Entity\Group $group)
        {
            if ($this->group->contains($group)) {
                $this->group->removeElement($group);
            }
        }

        public function clearGroup()
        {
            $this->group->clear();
        }

        public function getInputFilter()
        {
            if (!$this->inputFilter) {
                $inputFilter = new InputFilter();

                $factory = new InputFactory();

                $inputFilter->add($factory->createInput(array(
                    'name'       => 'id',
                    'required'   => true,
                    'filters'    => array(
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

                $inputFilter->add($factory->createInput(array(
                    'name'     => 'surname',
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

                $inputFilter->add($factory->createInput(array(
                    'name'     => 'password',
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
                                'min'      => 4,
                                'max'      => 100,
                            ),
                        ),
                    ),
                )));

                $inputFilter->add($factory->createInput(array(
                    'name'       => 'email',
                    'required'   => true,
                    'validators' => array(
                         array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                        array(
                            'name' => 'EmailAddress',
                        ),
                        array(
                            'name'      => '\DutchBridge\Validator\Doctrine\NoRecordExists',
                            'options'   => array(
                                'entity' => '\EasyACL\Entity\User',
                                'attribute' => 'email',
                                'exclude'   => array('attribute'=>'email', 'value'=>$this->email),
                            ),
                        ),
                    ),
                )));
                $inputFilter->add($factory->createInput(array(
                    'name'     => 'groups[]',
                    'required' => false,
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
