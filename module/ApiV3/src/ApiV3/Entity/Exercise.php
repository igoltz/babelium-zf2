<?php

namespace ApiV3\Entity;

use JMS\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"exercisecode"})}, indexes={@ORM\Index(name="FK_exercises_1", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class Exercise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"response", "exercise-list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="exercisecode", type="string", length=255, nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $exercisecode;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80, nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     * @Groups({"response"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=45, nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $language;

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulty", type="integer", nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $difficulty;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $status = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     * @Groups({"response", "exercise-list"})
     */
    private $visible = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_scope_id", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $fkScopeId = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $timecreated = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $timemodified = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $type = '5';

    /**
     * @var integer
     *
     * @ORM\Column(name="situation", type="integer", nullable=true)
     * @Groups({"response"})
     */
    private $situation;

    /**
     * @var integer
     *
     * @ORM\Column(name="competence", type="integer", nullable=true)
     * @Groups({"response"})
     */
    private $competence;

    /**
     * @var integer
     *
     * @ORM\Column(name="lingaspects", type="integer", nullable=true)
     * @Groups({"response"})
     */
    private $lingaspects;

    /**
     * @var string
     *
     * @ORM\Column(name="licence", type="string", length=60, nullable=false)
     * @Groups({"response"})
     */
    private $licence = 'cc-by';

    /**
     * @var string
     *
     * @ORM\Column(name="attribution", type="text", length=65535, nullable=true)
     * @Groups({"response"})
     */
    private $attribution;

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $likes = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikes", type="integer", nullable=false)
     * @Groups({"response"})
     */
    private $dislikes = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="ismodel", type="boolean", nullable=false)
     * @Groups({"response"})
     */
    private $ismodel = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="model_id", type="integer", nullable=true)
     * @Groups({"response"})
     */
    private $modelId;

    /**
     * @var \ApiV3\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user_id", referencedColumnName="id")
     * })
     */
    private $fkUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiV3\Entity\ExerciseDescriptor", inversedBy="fkExercise")
     * @ORM\JoinTable(name="rel_exercise_descriptor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_exercise_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_exercise_descriptor_id", referencedColumnName="id")
     *   }
     * )
     */
    private $fkExerciseDescriptor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiV3\Entity\Tag", inversedBy="fkExercise")
     * @ORM\JoinTable(name="rel_exercise_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_exercise_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $fkTag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkExerciseDescriptor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTag = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set exercisecode
     *
     * @param string $exercisecode
     *
     * @return Exercise
     */
    public function setExercisecode($exercisecode)
    {
        $this->exercisecode = $exercisecode;

        return $this;
    }

    /**
     * Get exercisecode
     *
     * @return string
     */
    public function getExercisecode()
    {
        return $this->exercisecode;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Exercise
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Exercise
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Exercise
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set difficulty
     *
     * @param integer $difficulty
     *
     * @return Exercise
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Exercise
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Exercise
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set fkScopeId
     *
     * @param integer $fkScopeId
     *
     * @return Exercise
     */
    public function setFkScopeId($fkScopeId)
    {
        $this->fkScopeId = $fkScopeId;

        return $this;
    }

    /**
     * Get fkScopeId
     *
     * @return integer
     */
    public function getFkScopeId()
    {
        return $this->fkScopeId;
    }

    /**
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return Exercise
     */
    public function setTimecreated($timecreated)
    {
        $this->timecreated = $timecreated;

        return $this;
    }

    /**
     * Get timecreated
     *
     * @return integer
     */
    public function getTimecreated()
    {
        return $this->timecreated;
    }

    /**
     * Set timemodified
     *
     * @param integer $timemodified
     *
     * @return Exercise
     */
    public function setTimemodified($timemodified)
    {
        $this->timemodified = $timemodified;

        return $this;
    }

    /**
     * Get timemodified
     *
     * @return integer
     */
    public function getTimemodified()
    {
        return $this->timemodified;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Exercise
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set situation
     *
     * @param integer $situation
     *
     * @return Exercise
     */
    public function setSituation($situation)
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * Get situation
     *
     * @return integer
     */
    public function getSituation()
    {
        return $this->situation;
    }

    /**
     * Set competence
     *
     * @param integer $competence
     *
     * @return Exercise
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return integer
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set lingaspects
     *
     * @param integer $lingaspects
     *
     * @return Exercise
     */
    public function setLingaspects($lingaspects)
    {
        $this->lingaspects = $lingaspects;

        return $this;
    }

    /**
     * Get lingaspects
     *
     * @return integer
     */
    public function getLingaspects()
    {
        return $this->lingaspects;
    }

    /**
     * Set licence
     *
     * @param string $licence
     *
     * @return Exercise
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get licence
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Set attribution
     *
     * @param string $attribution
     *
     * @return Exercise
     */
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;

        return $this;
    }

    /**
     * Get attribution
     *
     * @return string
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Exercise
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set dislikes
     *
     * @param integer $dislikes
     *
     * @return Exercise
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * Get dislikes
     *
     * @return integer
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * Set ismodel
     *
     * @param boolean $ismodel
     *
     * @return Exercise
     */
    public function setIsmodel($ismodel)
    {
        $this->ismodel = $ismodel;

        return $this;
    }

    /**
     * Get ismodel
     *
     * @return boolean
     */
    public function getIsmodel()
    {
        return $this->ismodel;
    }

    /**
     * Set modelId
     *
     * @param integer $modelId
     *
     * @return Exercise
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return integer
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Exercise
     */
    public function setFkUser(\ApiV3\Entity\User $fkUser = null)
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    /**
     * Get fkUser
     *
     * @return \ApiV3\Entity\User
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    /**
     * Add fkExerciseDescriptor
     *
     * @param \ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor
     *
     * @return Exercise
     */
    public function addFkExerciseDescriptor(\ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor)
    {
        $this->fkExerciseDescriptor[] = $fkExerciseDescriptor;

        return $this;
    }

    /**
     * Remove fkExerciseDescriptor
     *
     * @param \ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor
     */
    public function removeFkExerciseDescriptor(\ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor)
    {
        $this->fkExerciseDescriptor->removeElement($fkExerciseDescriptor);
    }

    /**
     * Get fkExerciseDescriptor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkExerciseDescriptor()
    {
        return $this->fkExerciseDescriptor;
    }

    /**
     * Add fkTag
     *
     * @param \ApiV3\Entity\Tag $fkTag
     *
     * @return Exercise
     */
    public function addFkTag(\ApiV3\Entity\Tag $fkTag)
    {
        $this->fkTag[] = $fkTag;

        return $this;
    }

    /**
     * Remove fkTag
     *
     * @param \ApiV3\Entity\Tag $fkTag
     */
    public function removeFkTag(\ApiV3\Entity\Tag $fkTag)
    {
        $this->fkTag->removeElement($fkTag);
    }

    /**
     * Get fkTag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkTag()
    {
        return $this->fkTag;
    }
}
