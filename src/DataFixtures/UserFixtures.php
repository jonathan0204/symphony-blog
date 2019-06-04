<?php
	
namespace App\DataFixtures;



use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	private $passwordEncoder;
	
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
		
		
    // Création d’un utilisateur de type “auteur”
	
	/**
	 * Load data fixtures with the passed EntityManager
	 *
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		// TODO: Implement load() method.
		$author = new User();
		$author->setEmail('author@monsite.com');
		$author->setRoles(['ROLE_AUTHOR']);
		$author->setPassword($this->passwordEncoder->encodePassword(
			$author,
			'authorpassword'
		));

        $manager->persist($author);

        // Création d’un utilisateur de type “adminiager->persist($admin);

	
		$admin = new User();
		$admin->setEmail('admin@monsite.com');
		$admin->setRoles(['ROLE_ADMIN']);
		$admin->setPassword($this->passwordEncoder->encodePassword(
			$admin,
			'adminpassword'
		));

        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
	