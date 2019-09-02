<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora", name="taxa", indexes={@ORM\Index(columns={"guid"})})
 */
class Taxon extends ClassBase {
    
    /**
     * http://rs.tdwg.org/dwc/terms/scientificNameID
     * 
     * An identifier for the nomenclatural details of a scientific name.
     * 
     * @ORM\ManyToOne(targetEntity="Name")
     * @ORM\JoinColumn(name="name_id", referencedColumnName="id", 
     *   nullable=false)
     * @var \VicFlora\Entities\Name
     */
    protected $name;
    
    /**
     * http://rs.tdwg.org/dwc/terms/taxonRank
     * 
     * The taxonomic rank of the most specific name in the scientificName.
     * 
     * @ORM\ManyToOne(targetEntity="TaxonTreeDefItem")
     * @ORM\JoinColumn(name="taxon_tree_def_item_id", referencedColumnName="id", 
     *   nullable=false)
     * @var \VicFlora\Entities\TaxonTreeDefItem
     */
    protected $taxonTreeDefItem;
    
    /**
     * http://rs.tdwg.org/dwc/terms/acceptedNameUsageID
     * 
     * An identifier for the name usage of the direct, most proximate 
     * higher-rank parent taxon (in a classification) of the most specific 
     * element of the scientificName.
     * 
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="accepted_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Taxon
     */
    protected $accepted;
    
    /**
     * http://rs.tdwg.org/dwc/terms/parentNameUsageID
     * 
     * An identifier for the name usage (documented meaning of the name 
     * according to a source) of the direct, most proximate higher-rank parent 
     * taxon (in a classification) of the most specific element of the 
     * scientificName.
     * 
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Taxon
     */
    protected $parent;
    
    /**
     * http://rs.tdwg.org/dwc/terms/originalNameUsageID
     * 
     * An identifier for the name usage in which the scientificName was 
     * originally established under the rules of the associated 
     * nomenclaturalCode. (basionym)
     * 
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="basionym_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Taxon
     */
    protected $basionym;
    
    /**
     * http://rs.tdwg.org/dwc/terms/nameAccordingToID
     * 
     * An identifier for the source in which the specific taxon concept 
     * circumscription is defined or implied. See nameAccordingTo:
     * The reference to the source in which the specific taxon concept 
     * circumscription is defined or implied - traditionally signified by the 
     * Latin "sensu" or "sec."
     * 
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="name_according_to_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Reference
     */
    protected $nameAccordingTo;
    
    /**
     * http://rs.tdwg.org/dwc/terms/taxonomicStatus
     * 
     * The status of the use of the scientificName as a label for a taxon.
     * 
     * @ORM\ManyToOne(targetEntity="TaxonomicStatus")
     * @ORM\JoinColumn(name="taxonomic_status_id", referencedColumnName="id")
     * @var \VicFlora\Entities\TaxonomicStatus
     */
    protected $taxonomicStatus;
    
    /**
     * http://rs.tdwg.org/dwc/terms/occurrenceStatus
     * 
     * A statement about the presence or absence of a Taxon at a Location.
     * 
     * @ORM\ManyToOne(targetEntity="OccurrenceStatus")
     * @ORM\JoinColumn(name="occurrence_status_id", referencedColumnName="id")
     * @var \VicFlora\Entities\OccurrenceStatus
     */
    protected $occurrenceStatus;
    
    /**
     * http://rs.tdwg.org/dwc/terms/establishmentMeans
     * 
     * The process by which the biological individual(s) represented in the 
     * Occurrence became established at the location.
     * 
     * @ORM\ManyToOne(targetEntity="EstablishmentMeans")
     * @ORM\JoinColumn(name="establishment_means_id", referencedColumnName="id")
     * @var \VicFlora\Entities\EstablishmentMeans
     */
    protected $establishmentMeans;
    
    /**
     * http://iucn.org/terms/threatStatus
     * 
     * Threat status of a taxon as defined by IUCN: 
     * http://www.iucnredlist.org/static/categories_criteria_3_1#categories
     * 
     * @ORM\ManyToOne(targetEntity="ThreatStatus")
     * @ORM\JoinColumn(name="threat_status_id", referencedColumnName="id")
     * @var \VicFlora\Entities\ThreatStatus
     */
    protected $threatStatus;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isEndemic;
    
    /**
     * http://rs.tdwg.org/dwc/terms/taxonRemarks
     * 
     * Comments or notes about the taxon or name.
     * 
     * @ORM\Column(type="text", name="taxon_remarks", nullable=true)
     * @var string
     */
    protected $taxonRemarks;
    
    /**
     * @ORM\Column(type="boolean", name="do_not_index", nullable=true)
     * @var bool
     */
    protected $doNotIndex;
}
