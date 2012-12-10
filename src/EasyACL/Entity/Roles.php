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
     * @ORM\Table(name="`roles`")
    */

    class Roles
    {
        protected $inputFilter;

        /**
         * @ORM\Id
         * @ORM\Column(type="integer",unique=true);
         * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
         * @ORM\Column(type="string", unique=true)
        */
        protected $name;

        /**
        * @ORM\ManyToMany(targetEntity="permission")
         * @ORM\JoinTable(name="roles_permission",
         *      joinColumns={@ORM\JoinColumn(name="roles_id", referencedColumnName="id")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")}
         *      )
        **/
        private $permissions;

        /**
         * @ORM\OneToOne(targetEntity="User")
         * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
        */
        protected $user_id;

        /**
         * @ORM\OneToOne(targetEntity="Group" )
         * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="SET NULL")
        */
        protected $group_id;

        /**
         * @ORM\Column(type="array")
        */
        protected $allowed_all;

                                /* Under this line you may edit functions, Don't worry you won't void the warranty i will guaranty you! */

        public function __construct()
        {
            $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
        }

        public function setUser(\ACL\Entity\User $user)
        {
            $this->user_id=$user;
        }

        public function setGroup(\ACL\Entity\Group $group)
        {
            $this->group_id=$group;
        }

        public function addPermission(\ACL\Entity\Permission $permission)
        {
            if (!$this->permissions->contains($permission)) {
                $this->permissions->add($permission);
            }
        }

        public function removePermission(\ACL\Entity\Permission $permission)
        {
            if ($this->permissions->contains($permission)) {
                $this->permissions->removeElement($permission);
            }
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
